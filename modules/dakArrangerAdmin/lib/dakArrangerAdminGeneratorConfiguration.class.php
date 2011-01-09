<?php

/**
 * arranger module configuration.
 *
 * @package    kvarteret_events
 * @subpackage arranger
 * @author     Endre Oma
 * @version    SVN: $Id: configuration.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class dakArrangerAdminGeneratorConfiguration extends BaseDakArrangerAdminGeneratorConfiguration
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
