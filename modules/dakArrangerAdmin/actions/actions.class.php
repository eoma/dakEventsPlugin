<?php

require_once dirname(__FILE__).'/../lib/dakArrangerAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dakArrangerAdminGeneratorHelper.class.php';

/**
 * arranger actions.
 *
 * @package    kvarteret_events
 * @subpackage arranger
 * @author     Endre Oma
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dakArrangerAdminActions extends autodakArrangerAdminActions
{

  public function preExecute() {
    parent::preExecute();

    $this->configuration->setUser($this->getUser());
  }

  public function getCredential()
  {
    $action = $this->getActionName();
    $user = $this->getUser();

    if (!$user->hasCredential('admin') && in_array($action, array('edit', 'update')))
    {
      $this->arranger = $this->getRoute()->getObject();
      $usersArrangers = $user->getArrangerIds();

      if (in_array($this->arranger->getId(), $usersArrangers)) {
        $this->getUser()->addCredential('owner');
      } else {
        $this->getUser()->removeCredential('owner');
      }
    }
 
    // the hijack is over, let the normal flow continue:
    return parent::getCredential();
  }

  protected function buildQuery()
  {
    $query = parent::buildQuery();
    // do what ever you like with the query like

    if ( $this->getUser()->isAuthenticated() && ! $this->getUser()->hasGroup('admin') ) {
      $arrangerUsers = $this->getUser()->getArrangerIds();

      if ( count($arrangerUsers) > 0 ) {
        $query->andWhereIn('id', $arrangerUsers);
      } else {
        // No events can be created with id set to null
        $query->andWhere('id is null');
      }
    }
    return $query;
  }

}
