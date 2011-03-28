<?php

require_once dirname(__FILE__).'/../lib/dakFestivalAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dakFestivalAdminGeneratorHelper.class.php';

/**
 * festival actions.
 *
 * @package    kvarteret_events
 * @subpackage festival
 * @author     Endre Oma
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dakFestivalAdminActions extends autodakFestivalAdminActions
{

  public function preExecute() {
    parent::preExecute();

    $this->configuration->setUser($this->getUser());
  }

  public function executeShow (sfWebRequest $request)
  {
    $this->dak_festival = $this->getRoute()->getObject();

    $q = Doctrine_Core::getTable('dakEvent')
      ->createQuery('e')
      ->setHydrationMode(Doctrine_Core::HYDRATE_ARRAY);
    Doctrine_Core::getTable('dakEvent')->defaultQueryOptions($q);

    $q->where('e.festival_id = ?', $request->getParameter('id'));
    //$q->andWhere('e.is_public = ?', true);

    $this->pager = new sfDoctrinePager('dakEvent', sfConfig::get('app_max_events_on_page'));
    $this->pager->setQuery($q);
    $this->pager->setPage($request->getParameter('page', 1));
    $this->pager->init();
  }

  protected function buildQuery()
  {
    $query = parent::buildQuery();
    // do what ever you like with the query like

    if ( $this->getUser()->isAuthenticated() && ! $this->getUser()->hasGroup('admin') ) {
      $arrangerUsers = $this->getUser()->getArrangerIds();

      $query->leftJoin($query->getRootAlias() . '.arrangers a2');

      if ( count($arrangerUsers) > 0 ) {
        $query->andWhereIn('a2.id', $arrangerUsers);
      } else {
        // No festivals can be created, edited or deleted with a.id set to null
        $query->andWhere('a2.id is null');
      }
    }
    return $query;
  }

  public function getCredential()
  {
    $action = $this->getActionName();
    $user = $this->getUser();

    if (!$user->hasCredential('admin') && in_array($action, array('copy', 'edit', 'update', 'delete', 'batchDelete')))
    {
      $this->dak_festival = $this->getRoute()->getObject();
      $usersArrangers = $user->getArrangerIds();

      $festivalArrangers = $this->dak_festival->getArrangers();
      $festivalArrangerIds = array();

      foreach ($festivalArrangers as $f) {
        $festivalArrangerIds[] = $f->getId();
      }

      if (count(array_intersect($festivalArrangerIds, $usersArrangers)) > 0) {
        $this->getUser()->addCredential('owner');
      } else {
        $this->getUser()->removeCredential('owner');
      }
    }
 
    // the hijack is over, let the normal flow continue:
    return parent::getCredential();
  }


  public function executeCopy(sfWebRequest $request)
  {
    $oldFestival = Doctrine_Core::getTable('dakFestival')->find($request->getParameter('id'));
    $newFestival = $oldFestival->copy();

    $newFestival->setTitle($newFestival->getTitle() . " copy");

    $startTimestamp = strtotime($newFestival->getStartDate() . ' ' . $newFestival->getStartTime());

    if ($startTimestamp < time()) {
      $newFestival->setStartDate(date('Y-m-d', time() + 86400));
      $newFestival->setEndDate(date('Y-m-d', time() + 86400 ));
    } else {
      $newFestival->setStartDate(date('Y-m-d', strtotime($newFestival->getStartDate()) + 86400));
      $newFestival->setEndDate(date('Y-m-d', strtotime($newFestival->getEndDate()) + 86400 ));
    }

    // See here http://stackoverflow.com/questions/2357498/copy-a-doctrine-object-with-all-relations/2663837#2663837
    foreach($oldFestival->getTable()->getRelations() as $relation) {
      if ($relation instanceof Doctrine_Relation_Association) {
        $ids = array();

        foreach ($relation->fetchRelatedFor($oldFestival) as $r) {    
            $ids[] = $r->getId();
        }

        $newFestival->link($relation->getAlias(), $ids);
      }
    }

    $newFestival->setCreatedAt(date('Y-m-d H:i:s'));
    $newFestival->setUpdatedAt(date('Y-m-d H:i:s'));

    if ($newFestival->isValid()) {
      $newFestival->save();
      $this->redirect('dak_festival_admin_edit', $newFestival);
    } else {
      $this->forward404("Couldn't copy the object, contact admin");
    }
  }

}
