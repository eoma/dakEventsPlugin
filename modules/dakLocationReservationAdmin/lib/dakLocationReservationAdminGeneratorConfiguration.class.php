<?php

/**
 * location_reservation module configuration.
 *
 * @package    kvarteret_events
 * @subpackage location_reservation
 * @author     Endre Oma
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dakLocationReservationAdminGeneratorConfiguration extends BaseDakLocationReservationAdminGeneratorConfiguration
{
  protected $user;

  public function setUser(sfGuardSecurityUser $user) {
    //echo "executed!";
    $this->user = $user;
  }
  
  public function getFilterFormOptions () {
    return array('currentUser' => $this->user);
  }

  public function getFormOptions () {
    return array('currentUser' => $this->user);
  }  
  
}
