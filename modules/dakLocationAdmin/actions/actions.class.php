<?php

require_once dirname(__FILE__).'/../lib/dakLocationAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dakLocationAdminGeneratorHelper.class.php';

/**
 * location actions.
 *
 * @package    kvarteret_events
 * @subpackage location
 * @author     Endre Oma
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dakLocationAdminActions extends autodakLocationAdminActions
{

  // Following sections taken from http://halestock.wordpress.com/2010/02/04/symfony-implementing-a-nested-set-part-three/

  public function executeDelete(sfWebRequest $request)
  {
    $request->checkCSRFProtection();

    $this->dispatcher->notify(new sfEvent($this, 'admin.delete_object', array('object' => $this->getRoute()->getObject())));

    if ($this->getRoute()->getObject()->getNode()->delete())
    {
      $this->getUser()->setFlash('notice', 'The item was deleted successfully.');
    }

    $this->redirect('@location');
  }

  protected function executeBatchDelete(sfWebRequest $request)
  {
    $ids = $request->getParameter('ids');
    $records = Doctrine_Query::create()
      ->from('ChangeType')
      ->whereIn('id', $ids)
      ->execute();
    foreach ($records as $record)
    {
      $record->getNode()->delete();
    }

    $this->getUser()->setFlash('notice', 'The selected items have been deleted successfully.');
    $this->redirect('@change_type');
  }

  protected function addSortQuery($query)
  {
    $query->addOrderBy('root_id asc');
    $query->addOrderBy('lft asc');
  }
}
