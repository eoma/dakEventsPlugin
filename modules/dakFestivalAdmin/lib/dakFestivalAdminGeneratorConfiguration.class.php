<?php

/**
 * festival module configuration.
 *
 * @package    kvarteret_events
 * @subpackage festival
 * @author     Endre Oma
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dakFestivalAdminGeneratorConfiguration extends BaseDakFestivalAdminGeneratorConfiguration
{

  protected $user;

  public function setUser(sfGuardSecurityUser $user) {
    $this->user = $user;
  }

  /**
   * Default options given to the filter form
   */
  public function getFilterFormOptions () {
    return array('currentUser' => $this->user);
  }

  /**
   * Default options given to the form
   */
  public function getFormOptions () {
    return array('currentUser' => $this->user);
  }

}
