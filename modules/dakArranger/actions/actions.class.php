<?php

/**
 * arranger actions.
 *
 * @package    kvarteret_events
 * @subpackage arranger
 * @author     Endre Oma
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dakArrangerActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
    $q = Doctrine_Core::getTable('dakArranger')
      ->createQuery('a')
      ->orderBy('a.name asc')
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    $this->pager = new sfDoctrinePager('dakEvent', sfConfig::get('app_max_arrangers_on_page'));
    $this->pager->setQuery($q);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  public function executeShow(sfWebRequest $request)
  {
    $this->arranger = Doctrine_Core::getTable('dakArranger')
      ->createQuery('a')
      ->where('a.id = ?', $request->getParameter('id'))
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY)
      ->fetchOne();

    $this->forward404Unless($this->arranger);
    $q = Doctrine_Core::getTable('dakEvent')
      ->createQuery('e');
    Doctrine_Core::getTable('dakEvent')->defaultQueryOptions($q);
    
    $q->where('e.arranger_id = ?', $request->getParameter('id'))
      ->andWhere('e.startDate >= ? OR e.endDate >= ?', array(date('Y-m-d'), date('Y-m-d')))
      ->andWhere('e.is_public = ?', true)
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);

    $this->pager = new sfDoctrinePager('dakEvent', sfConfig::get('app_max_events_on_page'));
    $this->pager->setQuery($q);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }
}
