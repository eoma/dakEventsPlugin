<?php

/**
 * festival filter form.
 *
 * @package    kvarteret_events
 * @subpackage filter
 * @author     Endre Oma
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PlugindakFestivalFormFilter extends BasedakFestivalFormFilter
{
  public function configure()
  {

    $this->setWidget('location_id', new sfWidgetFormDoctrineChoiceNestedSet(array(
      'model'     => 'location',
      'add_empty' => true,
    )));

  }
}
