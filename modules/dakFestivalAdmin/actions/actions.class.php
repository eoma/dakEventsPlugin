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
  }

  protected function buildQuery()
  {
    $query = parent::buildQuery();
    // do what ever you like with the query like

    if ( $this->getUser()->isAuthenticated() && ! $this->getUser()->hasGroup('admin') ) {
      $arrangerUsers = $this->getUser()->getArrangerIds();

      $query->leftJoin($query->getRootAlias() . '.arrangers a');

      if ( count($arrangerUsers) > 0 ) {
        $query->andWhereIn('a.id', $arrangerUsers);
      } else {
        // No fiestivals can be created, edited or deleted with a.id set to null
        $query->andWhere('a.id is null');
      }
    }
    return $query;
  }

  public function getCredential()
  {
    $action = $this->getActionName();
    $user = $this->getUser();

    if (!$user->hasCredential('admin') && in_array($action, array('edit', 'update', 'delete', 'batchDelete')))
    {
      $this->dak_festival = $this->getRoute()->getObject();
      $usersArrangers = $user->getArrangerIds();

      $festivalArrangers = $this->festival->getArrangers();
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


}
