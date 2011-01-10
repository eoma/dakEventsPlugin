<?php

/**
 * event actions.
 *
 * @package    kvarteret_events
 * @subpackage event
 * @author     Endre Oma
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dakEventActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {

    if ( ! $request->getParameter('sf_culture') )
    {
      if ( $this->getUser()->isFirstRequest() )
      {
        $culture = $request->getPreferredCulture(array('en', 'no'));
        $this->getUser()->setCulture($culture);
        $this->getUser()->isFirstRequest(false);
      }
      else
      {
        $culture = $this->getUser()->getCulture();
      }
 
      $this->redirect('@dak_event_index');
    }

    $q = Doctrine_Core::getTable('dakEvent')
      ->createQuery('e');
    Doctrine_Core::getTable('dakEvent')->defaultQueryOptions($q);

    $q->where('e.startDate >= ? OR e.endDate >= ?', array(date('Y-m-d'), date('Y-m-d')))
      ->andWhere('e.is_public = ?', true)
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    $this->pager = new sfDoctrinePager('dakEvent', sfConfig::get('app_max_events_on_page'));
    $this->pager->setQuery($q);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeShow(sfWebRequest $request)
  {
    // Instead of using objects we'll be using associative arrays
    // because of performance on the public interface.
    $q = Doctrine_Core::getTable('dakEvent')
      ->createQuery('e');
    Doctrine_Core::getTable('dakEvent')->defaultQueryOptions($q);
    $q->where('e.id = ?', $request->getParameter('id'))
      ->andWhere('e.is_public = ?', true)
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    $this->event = $q->fetchOne();

    $this->forward404Unless($this->event);
  }

}
