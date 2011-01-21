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

  }
}
