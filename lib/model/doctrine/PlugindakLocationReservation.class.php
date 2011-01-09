<?php

/**
 * locationReservation
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 * 
 * @package    kvarteret_events
 * @subpackage model
 * @author     Endre Oma
 * @version    SVN: $Id: Builder.php 7490 2010-03-29 19:53:27Z jwage $
 */
abstract class PlugindakLocationReservation extends BasedakLocationReservation
{

  // NEVER change the meaning of the strings the numbers points to.
  protected static $choices = array(
     0 => 'Not accepted',
     1 => 'Accepted',
     2 => 'Pending',
     3 => 'Unread',
  );

  public static function getStatusChoices()
  {
    return self::$choices;
  }

  public function getStatusString() {
    return self::$choices[ $this->getStatus() ];
  }

  public function getActivatedRequirements ()
  {
    $string = '';
    if ($this->relatedExists('requirementLightSound'))
      $string .= 'light and sound, ';

    if ($this->relatedExists('requirementPhotography'))
      $string .= 'photography, ';
    
    if ($this->relatedExists('requirementCatering'))
      $string .= 'catering, ';

    return substr($string, 0, -2);
  }
}
