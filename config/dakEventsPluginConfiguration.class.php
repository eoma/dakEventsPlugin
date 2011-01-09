<?php

class dakEventsPluginConfiguration extends sfPluginConfiguration
{
  public function initialize()
  {
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