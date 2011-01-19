<?php

/**
 * PlugindakLocationReservationRequirementBase form.
 *
 * @package    ##PROJECT_NAME##
 * @subpackage form
 * @author     ##AUTHOR_NAME##
 * @version    SVN: $Id: sfDoctrineFormPluginTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
abstract class PlugindakFileForm extends BasedakFileForm
{

  protected function setupInheritance()
  {
    parent::setupInheritance();
 
    $this->useFields(array('filename', 'description'));
 
    $this->widgetSchema['filename']    = new sfWidgetFormInputFile();
    $this->validatorSchema['filename'] = new sfValidatorFile(array(
      'path' => sfConfig::get('sf_upload_dir')
    ));
  }

  public function setup()
  {
    parent::setup();
  }

}
