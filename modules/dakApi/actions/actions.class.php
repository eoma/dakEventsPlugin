<?php

/**
 * api actions.
 *
 * @package    kvarteret_events
 * @subpackage api
 * @author     Endre Oma
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dakApiActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $this->forward('default', 'module');
  }

  public function executeArranger(sfWebRequest $request) {

    $subAction = $request->getParameter('subaction', 'list');

    $q = Doctrine_Core::getTable('dakArranger')
      ->createQuery('a')
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    if (($subAction == 'get') && ($request->hasParameter('id'))) {
      $limit = 1;
      $offset = 0;

      $q->where('a.id = ?', $request->getParameter('id'));
      $q->limit($limit);
      $dbResponse = $q->execute();

      $totalCount = $q->count();
      $count = count($dbResponse);

    } else if ($subAction == 'list') {
      $limit = intval($request->getParameter('limit', 20));
      $offset = 0;
      if ($limit > 0) {
        $offset = intval($request->getParameter('offset', 0));
      }

      $q->select('a.name, a.id')
        ->limit($limit)
        ->offset($offset);    
    
      $dbResponse = $q->execute();

      $totalCount = $q->count();
      $count = count($dbResponse);
    }

    $data = array(
      'limit' => $limit,
      'offset' => $offset,
      'count' => $count,
      'totalCount' => $totalCount,
      'data' => $dbResponse,
    );

    return $this->returnJson($data);
  }

  public function executeCategory(sfWebRequest $request) {

    $subAction = $request->getParameter('subaction', 'list');

    $q = Doctrine_Core::getTable('dakCategory')
      ->createQuery('c')
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    if (($subAction == 'get') && ($request->hasParameter('id'))) {
      $limit = 1;
      $offset = 0;

      $q->where('c.id = ?', $request->getParameter('id'));
      $q->limit($limit);
      $dbResponse = $q->execute();

    } else if ($subAction == 'list') {
      $limit = intval($request->getParameter('limit', 20));
      $offset = 0;
      if ($limit > 0) {
        $offset = intval($request->getParameter('offset', 0));
      }

      $q->select('c.name, c.id')
        ->limit($limit)
        ->offset($offset);    
    
      $dbResponse = $q->execute();
    }

    $totalCount = $q->count();
    $count = count($dbResponse);

    $data = array(
      'limit' => $limit,
      'offset' => $offset,
      'count' => $count,
      'totalCount' => $totalCount,
      'data' => $dbResponse,
    );

    return $this->returnJson($data);
  }
  
  public function executeLocation(sfWebRequest $request) {

    $subAction = $request->getParameter('subaction', 'list');

    $q = Doctrine_Core::getTable('dakLocation')
      ->createQuery('l')
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    if (($subAction == 'get') && ($request->hasParameter('id'))) {
      $limit = 1;
      $offset = 0;

      $q->where('l.id = ?', $request->getParameter('id'));
      $q->limit($limit);
      $dbResponse = $q->execute();

    } else if ($subAction == 'list') {
      $limit = intval($request->getParameter('limit', 20));
      $offset = 0;
      if ($limit > 0) {
        $offset = intval($request->getParameter('offset', 0));
      }

      $q->select('l.name, l.id')
        ->limit($limit)
        ->offset($offset);
    
      $dbResponse = $q->execute();
    }

    $totalCount = $q->count();
    $count = count($dbResponse);

    $data = array(
      'limit' => $limit,
      'offset' => $offset,
      'count' => $count,
      'totalCount' => $totalCount,
      'data' => $dbResponse,
    );

    return $this->returnJson($data);
  }

  public function executeEvent(sfWebRequest $request) {
    $subAction = $request->getParameter('subaction', 'get');

    if (($subAction == 'get') && ($request->hasParameter('id'))) {
      $limit = 1;
      $offset = 0;

      $q = Doctrine_Core::getTable('dakEvent')
        ->createQuery('e');
      Doctrine_Core::getTable('dakEvent')->defaultQueryOptions($q);
      $q->where('e.id = ?', $request->getParameter('id'))
        ->andWhere('e.is_public = ?', true)
        ->limit($limit)
        ->offset($offset)
        ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);
	
      $event = $q->execute();

      $totalCount = $q->count();
      $count = count($event);

      $data = array(
        'limit' => $limit,
        'offset' => $offset,
        'count' => $count,
        'totalCount' => $totalCount,
        'data' => $event,
      );
    }

    return $this->returnJson($data);
  }

  public function executeFestival(sfWebRequest $request) {
    $subAction = $request->getParameter('subaction', 'get');

    if (($subAction == 'get') && ($request->hasParameter('id'))) {
      $limit = 1;
      $offset = 0;

      $q = Doctrine_Core::getTable('dakFestival')
        ->createQuery('f');
      Doctrine_Core::getTable('festival')->defaultQueryOptions($q);
      $q->where('f.id = ?', $request->getParameter('id'))
        ->limit($limit)
        ->offset($offset)
        ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);
	
      $festival = $q->execute();

      $totalCount = $q->count();
      $count = count($festival);

      $data = array(
        'limit' => $limit,
        'offset' => $offset,
        'count' => $count,
        'totalCount' => $totalCount,
        'data' => $festival,
      );
    }

    if ($request->getRequestFormat() == 'json') {
      return $this->returnJson($data);
    } else {
      if ($subaction == 'get') {
        $this->festival = $festival;
        $this->setTemplate('festivalGet');
      }
    }
  }

  public function executeUpcomingEvents (sfWebRequest $request) {
    // This action can accept the parameters limit and offset

    $limit = intval($request->getParameter('limit', 20));
    $offset = 0;
    if ($limit > 0) {
      $offset = intval($request->getParameter('offset', 0));
    }

    $q = Doctrine_Core::getTable('dakEvent')
      ->createQuery('e');
    Doctrine_Core::getTable('dakEvent')->defaultQueryOptions($q);
    $q->where('e.startDate >= ? OR e.endDate >= ?', array(date('Y-m-d'), date('Y-m-d')))
      ->andWhere('e.is_public = ?', true)
      ->limit($limit)
      ->offset($offset)
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    $events = $q->execute();

    $totalCount = $q->count();
    $count = count($events);

    $data = array(
      'limit' => $limit,
      'offset' => $offset,
      'count' => $count,
      'totalCount' => $totalCount,
      'data' => $events,
    );

    if ($request->getRequestFormat() == 'json') {
      return $this->returnJson($data);
    } else {
      $this->events = $events;
      $this->latestUpdate = 0;

      foreach ($events as $e) {
        $t = strtotime($e['updated_at']);
        if ($t > $this->latestUpdate) {
          $this->latestUpdate = $t;
        }
      }
    }
  }

  public function executeFilteredEvents (sfWebRequest $request) {
    // This method will accept the following parameters:
    // location_id, arranger_id, category_id, festival_id,
    // startDate, endDate, limit, offset

    $q = Doctrine_Core::getTable('dakEvent')
      ->createQuery('e');
    Doctrine_Core::getTable('dakEvent')->defaultJoins($q);
    Doctrine_Core::getTable('dakEvent')->defaultOrderBy($q);
    $q->select('e.id');

    // extraArguments variable is for templates wishing to use current url.
    // Probably wrong way to do it.
    $this->extraArguments = '';

    if ($request->hasParameter('location_id')) {
      $this->extraArguments .= '&location_id=' . $request->getParameter('location_id');
      $location_id = explode(',', $request->getParameter('location_id'));
      $location_id = array_map(create_function('$value', 'return (int)$value;'), $location_id);
      $q->andWhereIn('e.location_id', $location_id);
    }
    
    if ($request->hasParameter('arranger_id')) {
      $this->extraArguments .= '&arranger_id=' . $request->getParameter('arranger_id');
      $arranger_id = explode(',', $request->getParameter('arranger_id'));
      $arranger_id = array_map(create_function('$value', 'return (int)$value;'), $arranger_id);
      $q->andWhereIn('e.arranger_id', $arranger_id);
    }

    if ($request->hasParameter('category_id')) {
      $this->extraArguments .= '&category_id=' . $request->getParameter('category_id');
      $category_id = explode(',', $request->getParameter('category_id'));
      $category_id = array_map(create_function('$value', 'return (int)$value;'), $category_id);
      $q->andWhereIn('c.id', $category_id);
    }

    if ($request->hasParameter('festival_id')) {
      $this->extraArguments .= 'festival_id=' . $request->getParameter('festival_id');
      $festival_id = explode(',', $request->getParameter('festival_id'));
      $festival_id = array_map(create_function('$value', 'return (int)$value;'), $festival_id);
      $q->andWhereIn('e.festival_id', $festival_id);
    }

    if ($request->hasParameter('startDate')) {
      $this->extraArguments .= '&startDate=' . $request->getParameter('startDate');
      $startDate = $request->getParameter('startDate');
      $q->andWhere('e.startDate >= ? OR e.endDate >= ?', array($startDate, $startDate));
    } else {
      $q->andWhere('e.startDate >= ? OR e.endDate >= ?', array(date('Y-m-d'), date('Y-m-d')));
    }

    if ($request->hasParameter('endDate')) {
      $this->extraArguments .= '&endDate=' . $request->getParameter('endDate');
      $endDate = $request->getParameter('endDate');
      $q->andWhere('e.startDate <= ? OR e.endDate <= ?', array($endDate, $endDate));
    }

    // Don't fetch non-public events
    $q->andWhere('e.is_public = ?', true);

    $limit = intval($request->getParameter('limit', 20));
    $offset = 0;
    if ($limit > 0) {
      $offset = intval($request->getParameter('offset', 0));
    }

    $q->limit($limit)->offset($offset);

    $q->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    $eventIdsResult = $q->execute();
    $totalCount = $q->count();

    if (count($eventIdsResult) > 0) {
      $eventIds = array();
      foreach ($eventIdsResult as $e) {
        $eventIds[] = $e['id'];
      }

      $q = Doctrine_Core::getTable('dakEvent')->createQuery('e');
      Doctrine_Core::getTable('dakEvent')->defaultQueryOptions($q);

      $q->whereIn('e.id', $eventIds);
      $q->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

      $events = $q->execute();
    } else {
      $events = array();
    }

    $count = count($events);

    $data = array(
      'limit' => $limit,
      'offset' => $offset,
      'count' => $count,
      'totalCount' => $totalCount,
      'data' => $events,
    );

    if ($request->getRequestFormat() == 'json') {
      return $this->returnJson($data);
    } else {
      $this->events = $events;
      $this->latestUpdate = 0;

      foreach ($events as $e) {
        $t = strtotime($e['updated_at']);
        if ($t > $this->latestUpdate) {
          $this->latestUpdate = $t;
        }
      }
    }
  }

  public function returnJson($data) {
    $this->data = $data;

    if (sfConfig::get('sf_environment') == 'dev' && !$this->getRequest()->isXmlHttpRequest()) {
      $this->setLayout('json_debug'); 
      $this->setTemplate('json_debug', 'api');
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
