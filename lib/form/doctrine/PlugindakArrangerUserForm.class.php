<?php

/**
 * arrangerUser form.
 *
 * @package    kvarteret_events
 * @subpackage form
 * @author     Endre Oma
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PlugindakArrangerUserForm extends BasedakArrangerUserForm
{
  public function setup()
  {
    parent::setup();

    if ( $this->getOption( 'hideArranger', false ) ) {
      // Unsetting the arranger_id. Remember to set correct value in doBind() of the "parent" form
      // using this form
      unset($this->widgetSchema['arranger_id']);
    }

    if ( ! $this->isNew() )
    {
      $this->widgetSchema['delete'] = new sfWidgetFormInputCheckbox();
      $this->validatorSchema['delete'] = new sfValidatorPass();
    }
  }
}
