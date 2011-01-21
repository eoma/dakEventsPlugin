<?php

/**
 * requirementCatering form.
 *
 * @package    kvarteret_events
 * @subpackage form
 * @author     Endre Oma
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PlugindakPictureForm extends BasedakPictureForm
{
  /**
   * @see dakLocationReservationRequirementForm
   */
  public function setup()
  {
    parent::setup();

    unset($this['events_list']);

    $this->validatorSchema['filename']->setOption('mime_types', 'web_images');
    $this->validatorSchema['filename']->setOption('path', sfConfig::get('sf_upload_dir') . '/pictures');

    sfApplicationConfiguration::getActive()->loadHelpers(array('Url'));

    $this->setWidget('filename', new sfWidgetFormInputFileEditable(array(
      'file_src'    => public_path('') . basename(sfConfig::get('sf_upload_dir')) . '/pictures/'.$this->getObject()->getFilename(),
      'edit_mode'   => !$this->isNew(),
      'is_image'    => true,
      'with_delete' => false,
    )));

  }
}
