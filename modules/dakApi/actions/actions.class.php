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
    //$this->forward('default', 'module');
  }

  public function executeArranger(sfWebRequest $request) {

    $this->subAction = $request->getParameter('subaction', 'list');

    $q = Doctrine_Core::getTable('dakArranger')
      ->createQuery('a')
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    if (($this->subAction == 'get') && ($request->hasParameter('id'))) {
      $limit = 1;
      $offset = 0;

      $q->where('a.id = ?', $request->getParameter('id'));
      $q->limit($limit);
      $dbResponse = $q->execute();

      $totalCount = $q->count();
      $count = count($dbResponse);

    } else if ($this->subAction == 'list') {
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

    if ($request->getRequestFormat() == 'json') {
      return $this->returnJson($data);
    } else {
      $this->data = $data;
    }
  }

  public function executeCategory(sfWebRequest $request) {

    $this->subAction = $request->getParameter('subaction', 'list');

    $q = Doctrine_Core::getTable('dakCategory')
      ->createQuery('c')
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    if (($this->subAction == 'get') && ($request->hasParameter('id'))) {
      $limit = 1;
      $offset = 0;

      $q->where('c.id = ?', $request->getParameter('id'));
      $q->limit($limit);
      $dbResponse = $q->execute();

    } else if ($this->subAction == 'list') {
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

    if ($request->getRequestFormat() == 'json') {
      return $this->returnJson($data);
    } else {
      $this->data = $data;
    }
  }
  
  public function executeLocation(sfWebRequest $request) {

    $this->subAction = $request->getParameter('subaction', 'list');

    $q = Doctrine_Core::getTable('dakLocation')
      ->createQuery('l')
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    if (($this->subAction == 'get') && ($request->hasParameter('id'))) {
      $limit = 1;
      $offset = 0;

      $q->where('l.id = ?', $request->getParameter('id'));
      $q->limit($limit);
      $dbResponse = $q->execute();

    } else if ($this->subAction == 'list') {
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

    if ($request->getRequestFormat() == 'json') {
      return $this->returnJson($data);
    } else {
      $this->data = $data;
    }
  }

  public function executeEvent(sfWebRequest $request) {
    $this->subAction = $request->getParameter('subaction', 'get');

    if (($this->subAction == 'get') && ($request->hasParameter('id'))) {
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
	
      $event = $this->prepareEventPictures($q->execute());

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

    if ($request->getRequestFormat() == 'json') {
      return $this->returnJson($data);
    } else {
      $this->data = $data;
    }
  }

  public function executeFestival(sfWebRequest $request) {
    $this->subAction = $request->getParameter('subaction', 'get');

    if (($this->subAction == 'get') && ($request->hasParameter('id'))) {
      $limit = 1;
      $offset = 0;

      $q = Doctrine_Core::getTable('dakFestival')
        ->createQuery('f');
      Doctrine_Core::getTable('dakFestival')->defaultQueryOptions($q);
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
      $this->data = $data;
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
    // This specific query will ensure it only picks events currently
    // happening or will happen
    $q->where('e.startDate >= ? OR e.endDate > ? OR (e.endDate = ? AND e.endTime >= ?)', array(date('Y-m-d'), date('Y-m-d'), date('Y-m-d'), date('H:i:s')))
      ->andWhere('e.is_public = ?', true)
      ->limit($limit)
      ->offset($offset)
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    $events = $this->prepareEventPictures($q->execute());

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
      $this->data = $data;
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
    // startDate, endDate, history, limit, offset

    $history = $request->getParameter('history', 'future');
    // The history parameter is only good for getting mostly past events
    // without specifying a date and getting it sorted from the most recent
    // to the oldest. Can have values future or past. only past is
    // given special meaning.

    $q = Doctrine_Core::getTable('dakEvent')
      ->createQuery('e');
    $q->select('e.id');
    Doctrine_Core::getTable('dakEvent')->defaultJoins($q);

    if ($history == 'past') {
      Doctrine_Core::getTable('dakEvent')->defaultOrderBy($q, 'desc');
    } else {
      Doctrine_Core::getTable('dakEvent')->defaultOrderBy($q);
    }

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

    if ($history == 'past') {
      $this->extraArguments .= '&history=past';

      if ($request->hasParameter('startDate')) {
        $this->extraArguments .= '&startDate=' . $request->getParameter('startDate');
        $startDate = $request->getParameter('startDate');
        $q->andWhere('e.startDate >= ? OR e.endDate >= ?', array($startDate, $startDate));
      }

      if ($request->hasParameter('endDate')) {
        $this->extraArguments .= '&endDate=' . $request->getParameter('endDate');
        $endDate = $request->getParameter('endDate');
        $q->andWhere('e.startDate <= ? OR e.endDate <= ?', array($endDate, $endDate));
      } else {
        // This specific query will ensure it only picks events that
        // has already happened
        $q->andWhere('e.endDate < ? OR (e.endDate = ? AND e.endTime < ?)', array(date('Y-m-d'), date('Y-m-d'), date('H:i:s')));        
      }
	} else {
      // Future events
      if ($request->hasParameter('startDate')) {
        $this->extraArguments .= '&startDate=' . $request->getParameter('startDate');
        $startDate = $request->getParameter('startDate');
        $q->andWhere('e.startDate >= ? OR e.endDate >= ?', array($startDate, $startDate));
      } else {
        // This specific query will ensure it only picks events currently
        // happening or will happen
        $q->andWhere('e.startDate >= ? OR e.endDate > ? OR (e.endDate = ? AND e.endTime >= ?)', array(date('Y-m-d'), date('Y-m-d'), date('Y-m-d'), date('H:i:s')));
      }

      if ($request->hasParameter('endDate')) {
        $this->extraArguments .= '&endDate=' . $request->getParameter('endDate');
        $endDate = $request->getParameter('endDate');
        $q->andWhere('e.startDate <= ? OR e.endDate <= ?', array($endDate, $endDate));
      }
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
      if ($history == 'past') {
        Doctrine_Core::getTable('dakEvent')->defaultQueryOptions($q, 'desc');
      } else {
        Doctrine_Core::getTable('dakEvent')->defaultQueryOptions($q);
      }

      $q->whereIn('e.id', $eventIds);
      $q->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

      $events = $this->prepareEventPictures($q->execute());
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
      $this->data = $data;
      $this->latestUpdate = 0;

      foreach ($events as $e) {
        $t = strtotime($e['updated_at']);
        if ($t > $this->latestUpdate) {
          $this->latestUpdate = $t;
        }
      }
    }
  }

  protected function prepareEventPictures ($events) {
    $transformRouteArgs = array(
      'format' => 'primaryPicture',
      'type' => 'dakPicture',
    );

    $this->getContext()->getConfiguration()->loadHelpers('Url', 'Image');
    foreach ($events as &$e) {
      if (!empty($e['primaryPicture']['id'])) {
        $e['primaryPicture']['url'] = public_path('uploads/dakpicture', true) . '/' . $e['primaryPicture']['filename'];

        $transformRouteArgs['id'] = $e['primaryPicture']['id'];
        $thumbSizes = ImageHelper::TransformSize($transformRouteArgs['format'], $e['primaryPicture']['width'], $e['primaryPicture']['height']);

        $e['primaryPicture']['thumb'] = array(
          'url' => url_for('dak_thumb', $transformRouteArgs, true),
          'width' => $thumbSizes['width'],
          'height' => $thumbSizes['height'],
        );
      }

      if (!empty($e['pictures'])) {
        foreach ($e['pictures'] as &$p) {
          $p['url'] = public_path('uploads/dakpicture', true) . '/' . $p['filename'];

          $transformRouteArgs['id'] = $p['id'];
          $thumbSizes = ImageHelper::TransformSize($transformRouteArgs['format'], $p['width'], $p['height']);

          $p['thumb'] = array(
            'url' => url_for('dak_thumb', $transformRouteArgs, true),
            'width' => $thumbSizes['width'],
            'height' => $thumbSizes['height'],
          );
	}
      }
    }

    return $events;
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
