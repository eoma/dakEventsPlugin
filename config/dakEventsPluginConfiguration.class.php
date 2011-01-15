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

    $adminModules = array(
      'dakEventAdmin',
      'dakFestivalAdmin',
      'dakArrangerAdmin',
      'dakCategoryAdmin',
      'dakLocationAdmin',
      'dakLocationReservationAdmin',
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
