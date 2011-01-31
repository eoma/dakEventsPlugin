<?php

require_once dirname(__FILE__).'/../lib/dakPictureAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dakPictureAdminGeneratorHelper.class.php';

/**
 * arranger actions.
 *
 * @package    kvarteret_events
 * @subpackage arranger
 * @author     Endre Oma
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dakPictureAdminActions extends autodakPictureAdminActions
{

  public function preExecute() {
    parent::preExecute();

    $this->configuration->setUser($this->getUser());
  }

  public function executeJsonSearch (sfWebRequest $request) {
    $term = trim($request->getParameter('term', ''));

    $description = '';
    if ($term != '') {
      $description = '%' . $term . '%';
    }

    $q = Doctrine_Core::getTable('dakPicture')->createQuery('p');
    PluginTagTable::getObjectTaggedWithQuery('dakPicture', $term, $q);

    $where = $q->getDqlPart('where');
    if ($where[0] == 'false') { // No elements with the (possible) tags have been found
      $q = null;
      $q = Doctrine_Core::getTable('dakPicture')->createQuery('p');
    }

    $q->select('p.id, p.description, p.height, p.width');
    $q->orWhere('p.description LIKE ?', $description);
    $q->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    $q->limit(20);

    $result = $q->execute();

    $this->getContext()->getConfiguration()->loadHelpers('Url', 'UrlExtra', 'Image');

    $thumbRouteArgs = array(
      'type' => 'dakPicture',
      'format' => 'list'
    );

    foreach ($result as &$r) {
      $thumbRouteArgs['id'] = $r['id'];
      $r['thumbUrl'] = UrlExtraHelper::url_for_app('frontend', 'dak_thumb', $thumbRouteArgs);

      $thumbSizes = ImageHelper::TransformSize($thumbRouteArgs['format'], $r['width'], $r['height']);
      $r['thumbHeight'] = $thumbSizes['height'];
      $r['thumbWidth'] = $thumbSizes['width'];
    }

    return $this->returnJson($result);
  }

  public function returnJson($data) {
    $this->data = $data;

    if (sfConfig::get('sf_environment') == 'dev' && !$this->getRequest()->isXmlHttpRequest()) {
      $this->getResponse()->setHttpHeader('Content-type','text/plain');
      return $this->renderText(var_dump($data));
    } else {
      $this->getResponse()->setHttpHeader('Content-type','application/json');

      $string = '';

      if ( isset( $_GET['callback'] ) ) {
        $string = $_GET['callback'] . '(' . json_encode($data) . ')';
      } else {
        $string = json_encode($data);
      }
      return $this->renderText($string);
    }
  }

}
