<?php

/**
 * festivalArranger form.
 *
 * @package    kvarteret_events
 * @subpackage form
 * @author     Endre Oma
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PlugindakFestivalArrangerForm extends BasedakFestivalArrangerForm
{
  public function setup()
  {
    parent::setup();

    if ( $this->getOption( 'hideFestival', false ) ) {
      // Unsetting the arranger_id. Remember to set correct value in doBind() of the "parent" form
      // using this form
      unset($this->widgetSchema['festival_id']);
    }

    if ( ! $this->isNew() )
    {
      $this->widgetSchema['delete'] = new sfWidgetFormInputCheckbox();
      $this->validatorSchema['delete'] = new sfValidatorPass();
    }

  }
}
