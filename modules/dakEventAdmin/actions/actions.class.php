<?php

require_once dirname(__FILE__).'/../lib/dakEventAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dakEventAdminGeneratorHelper.class.php';

/**
 * event actions.
 *
 * @package    kvarteret_events
 * @subpackage event
 * @author     Endre Oma
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dakEventAdminActions extends autodakEventAdminActions
{

  public function preExecute() {
    parent::preExecute();

    $this->configuration->setUser($this->getUser());
  }

  public function getCredential()
  {
    $action = $this->getActionName();
    $user = $this->getUser();

    if (!$user->hasCredential('admin') && in_array($action, array('copy', 'edit', 'delete', 'update', 'batchDelete')))
    {
      $this->dak_event = $this->getRoute()->getObject();

      if (in_array($this->dak_event->getArrangerId(), $user->getArrangerIds())) {
        $this->getUser()->addCredential('owner');
      } else {
        $this->getUser()->removeCredential('owner');
      }
    }
 
    // the hijack is over, let the normal flow continue:
    return parent::getCredential();
  }

  public function executeShow(sfWebRequest $request) {
    $this->dak_event = $this->getRoute()->getObject();
  }

  public function executeNew(sfWebRequest $request)
  {

    $options = $this->configuration->getFormOptions();

    if ($request->hasParameter('festival_id'))
    {
      $options['festival_id'] = $request->getParameter('festival_id');
    }

    $this->form = $this->configuration->getForm(null, $options);
    $this->dak_event = $this->form->getObject();
  }

  public function executeCopy(sfWebRequest $request)
  {
    $oldEvent = Doctrine_Core::getTable('dakEvent')->find($request->getParameter('id'));
    $newEvent = $oldEvent->copy();

    $newEvent->setTitle($newEvent->getTitle() . " copy");
    $newEvent->setIsPublic(false);

    $startTimestamp = strtotime($newEvent->getStartDate() . ' ' . $newEvent->getStartTime());

    if ($startTimestamp < time()) {
      $newEvent->setStartDate(date('Y-m-d', time() + 86400));
      $newEvent->setEndDate(date('Y-m-d', time() + 86400 ));
    } else {
      $newEvent->setStartDate(date('Y-m-d', strtotime($newEvent->getStartDate()) + 86400));
      $newEvent->setEndDate(date('Y-m-d', strtotime($newEvent->getEndDate()) + 86400 ));
    }

    // See here http://stackoverflow.com/questions/2357498/copy-a-doctrine-object-with-all-relations/2663837#2663837
    foreach($oldEvent->getTable()->getRelations() as $relation) {
      if ($relation instanceof Doctrine_Relation_Association) {
        $ids = array();

        foreach ($relation->fetchRelatedFor($oldEvent) as $r) {    
            $ids[] = $r->getId();
        }

        $newEvent->link($relation->getAlias(), $ids);
      }
    }

    $newEvent->setCreatedAt(date('Y-m-d H:i:s'));
    $newEvent->setUpdatedAt(date('Y-m-d H:i:s'));

    if ($newEvent->isValid()) {
      $newEvent->save();
      $this->redirect('dak_event_admin_edit', $newEvent);
    } else {
      $this->forward404("Couldn't copy the object, contact admin");
    }
  }

  protected function buildQuery()
  {
    $query = parent::buildQuery();
    // do what ever you like with the query like

    if ( $this->getUser()->isAuthenticated() && ! $this->getUser()->hasGroup('admin') ) {
      $arrangerUsers = $this->getUser()->getArrangerIds();

      if ( count($arrangerUsers) > 0 ) {
        $query->andWhereIn('arranger_id', $arrangerUsers);
      } else {
        // No events can be created with arranger_id set to null
        $query->andWhere('arranger_id is null');
      }
    }
    return $query;
  }


}
