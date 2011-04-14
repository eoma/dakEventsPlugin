<?php

/**
 * requirementPhotography form.
 *
 * @package    kvarteret_events
 * @subpackage form
 * @author     Endre Oma
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PlugindakRequirementPhotographyForm extends BasedakRequirementPhotographyForm
{
  /**
   * @see locationReservationRequirementForm
   */
  public function setup()
  {
    parent::setup();

    unset( $this['created_at'], $this['updated_at'] );
    
    if ( $this->getOption( 'hideLocationReservation', false ) ) {
      // Unsetting the locationReservation_id. Remember to set correct value in doBind() of the "parent" form
      // using this form
      unset($this->widgetSchema['locationReservation_id']);
    }

    $meetAt = array( 'date' => date('Y-m-d', time() + 86400), 'time' => '19:00' );
    $meetAt = $this->getOption( 'meetAt', $meetAt );

    $this->setDefault('meetAtDate', $meetAt['date']);
    $this->setDefault('meetAtTime', $meetAt['time']);

    $this->widgetSchema['meetAtDate']->setOption('label', 'Meet at date');
    $this->widgetSchema['meetAtTime']->setOption('label', 'Meet at time');

  }
}
