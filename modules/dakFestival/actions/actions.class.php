<?php

/**
 * event actions.
 *
 * @package    kvarteret_events
 * @subpackage event
 * @author     Endre Oma
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dakFestivalActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $q = Doctrine_Core::getTable('dakFestival')
      ->createQuery('f')
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    Doctrine_Core::getTable('dakFestival')->defaultQueryOptions($q);

    $q->where('f.startDate >= ? OR f.endDate >= ?', array(date('Y-m-d'), date('Y-m-d')));

    $this->pager = new sfDoctrinePager('dakFestival', sfConfig::get('app_max_festivals_on_page'));
    $this->pager->setQuery($q);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeShow(sfWebRequest $request)
  {
    // Instead of using objects we'll be using associative arrays
    // because of performance on the public interface.
    $q = Doctrine_Core::getTable('dakFestival')
      ->createQuery('f')
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);
    Doctrine_Core::getTable('dakFestival')->defaultQueryOptions($q);

    $q->where('f.id = ?', $request->getParameter('id'));

    $this->festival = $q->fetchOne();

    $q = Doctrine_Core::getTable('dakEvent')
      ->createQuery('e')
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);
    Doctrine_Core::getTable('dakEvent')->defaultQueryOptions($q);

    $q->where('e.festival_id = ?', $request->getParameter('id'));
    $q->andWhere('e.is_public = ?', true);

    $this->pager = new sfDoctrinePager('dakEvent', sfConfig::get('app_max_events_on_page'));
    $this->pager->setQuery($q);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();

    $this->forward404Unless($this->festival);
  }

}
