<?php

require_once dirname(__FILE__).'/../lib/dakLocationReservationAdminGeneratorConfiguration.class.php';
require_once dirname(__FILE__).'/../lib/dakLocationReservationAdminGeneratorHelper.class.php';

/**
 * location_reservation actions.
 *
 * @package    kvarteret_events
 * @subpackage location_reservation
 * @author     Endre Oma
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dakLocationReservationAdminActions extends autodakLocationReservationAdminActions
{

  public function preExecute()
  {
    parent::preExecute();

    $this->configuration->setUser($this->getUser());
  }

}
