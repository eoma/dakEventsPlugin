<?php

require_once(__DIR__ . '/IXR_Library.php');

class dakEventsPing {

	private $config = array();

	private $pingOperations = array();

	private static $instance = null;

	public function __construct() {
		$this->config = sfConfig::get("app_dakEvents_pingOnUpdate");

		foreach ($this->config as &$c) {
			// Will fill undefined attributes with default values
			if (empty($c['key'])) {
				$c['key'] = null;
			}

			if (empty($c['triggerOn']) && !is_array($c['triggerOn'])) {
				$c['triggerOn'] = array();
			}
		}
		unset($c);

		self::debugLog('{'. __CLASS__ . '}' . var_export($this->config, true));
	}

	public static function getInstance() {
		if (self::$instance == null) {
			self::$instance = new dakEventsPing();
		}

		return self::$instance;
	}

	public static function pingEvent (sfEvent $event, $result = null) {
		$inst = self::getInstance();

		$args = array(
			'type' => 'update',
			'arrangement' => 'event',
			'id' => $event['id']
		);
		
		if ($event->getName() == "dak.event.deleted") {
			$args['type'] = 'delete';
		}

		$inst->pingOperations[] = $args;
	}

	public static function pingFestival (sfEvent $festival, $result = null) {
		$inst = self::getInstance();

		$args = array(
			'type' => 'update',
			'arrangement' => 'festival',
			'id' => $festival['id']
		);
		
		if ($festival->getName() == "dak.festival.deleted") {
			$args['type'] = 'delete';
		}

		$inst->pingOperations[] = $args;
	}

    public static function execute(sfEvent $e, $result = null) {
		$inst = self::getInstance();

		while (!empty($inst->pingOperations)) {
			$op = array_pop($inst->pingOperations);
			if ($op != null) {
				$inst->doRequests($op);
			}
		}
	}

	public function doRequests(array $args) {
		self::debugLog('{'. __CLASS__ . '}' . ' sending request with params:' . var_export($args, true));

		foreach ($this->config as $clientName => $clientConfig) {
			if ($clientConfig['type'] == 'xmlrpc-wp') {
				$this->xmlrpcWpRequest($clientName, $clientConfig, $args);
			} else if ($clientConfig['type'] == 'ping') {
				$this->pingClient($clientConfig['url'], $args['type'], $args['arrangement'], $args['id'], $args['key']);
			}
		}
	}

	protected function pingClient ($url, $pingType, $arrangementType, $arrangementId, $key=null) {
		$queryArgs = array(
			'type' => $pingType,
			'arangement' => $arrangementType,
			'id' => $arrangementId,
		);
		
		if ($key !== null || !empty($key)) {
			$queryArgs['key'] = $key;
		}

		$retVal = NULL;

		if (in_array('curl', get_loaded_extensions())) {
			// Open connection
			$ch = curl_init();

			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CORLOPT_POSTFIELDS, http_build_query($queryArgs));
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);

			$retVal = curl_exec($ch);
			curl_close($ch);
		} else {

			$queryString = http_build_query($queryArgs);

			if(strpos($url, '?') === FALSE) {
				$url .= '?' . $queryString;
			} else {
				$url .= '&' . $queryString;
			}

			$retVal = file_get_contents($url);
		}

		return $retVal;
	}

	protected function xmlrpcWpRequest($clientName, array $clientConfig, array $args, $payLoad = null) {
		$ixr = new IXR_Client($clientConfig['url']);

		$queryArgs = array(
			$clientConfig['methodName'],
			$clientConfig['user'],
			$clientConfig['pass'],
			$clientConfig['key'],
			$args['type'],
			$args['arrangement'],
			$args['id']
		);

		if (!empty($payLoad)) {
			$queryArgs[] = $payLoad;
		}

		$ixr->debug = 1;

		ob_start();
		if (!call_user_func_array(array($ixr, 'query'), $queryArgs)) {
			$s = ob_get_contents();
			self::debugLog('{' . __METHOD__ . '} err for ' . $clientName . ':' . $ixr->getErrorCode() . ": " . $ixr->getErrorMessage() . " :: " . $s );
		}

		ob_end_clean();
	}

	protected static function debugLog($text) {
		if (sfContext::hasInstance()) {
			sfContext::getInstance()->getLogger()->debug($text);
		}
	}
}
