<?php

class dakEventsPluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {

    if (!sfConfig::get('dak_events_module_web_dir'))
    {
      sfConfig::set('dak_events_module_web_dir', '/dakEventsPlugin');
    }

    $this->dispatcher->connect('user.method_not_found', array('dakEventsUser', 'methodNotFound'));

    if (sfConfig::get('app_dakEvents_pingOnUpdate')) {
      /* Only enable eventlisteners if the config pingOnUpdate exists
       * under the name dakEvents
       */

      /* Eventlisteners */
      $this->dispatcher->connect('dak.event.saved', array('dakEventsPing', 'pingEvent'));
      $this->dispatcher->connect('dak.event.deleted', array('dakEventsPing', 'pingEvent'));

      $this->dispatcher->connect('dak.festival.saved', array('dakEventsPing', 'pingFestival'));
      $this->dispatcher->connect('dak.festival.deleted', array('dakEventsPing', 'pingFestival'));
    }

    $adminModules = array(
      'dakEventAdmin',
      'dakFestivalAdmin',
      'dakArrangerAdmin',
      'dakCategoryAdmin',
      'dakLocationAdmin',
      'dakLocationReservationAdmin',
      'dakPictureAdmin',
    );

    foreach ($adminModules as $module)
    {
      if (in_array($module, sfConfig::get('sf_enabled_modules', array())))
      {
        $this->dispatcher->connect('routing.load_configuration', array('dakRouting', 'addRouteFor' . str_replace('dak', '', $module)));
      }
    }
  }
}
