<?php

// Depends on UrlHelper

class UrlExtraHelper
{

  protected static $relativeUrlRoot = null;
  protected static $apps = array();

  public static function url_for_app($app, $route, $args)
  {
    // This one depends on your app.yml applicationLinks settings
    if (is_null(self::$relativeUrlRoot)) {
      if (sfConfig::get('sf_no_script_name')) {
        self::$relativeUrlRoot = sfContext::getInstance()->getRequest()->getRelativeUrlRoot();
      } else {
        self::$relativeUrlRoot = sfContext::getInstance()->getRequest()->getScriptName();
      }
    }

    if (!isset(self::$apps[$app]))
    {
      self::$apps[$app] = sfConfig::get('app_applicationLinks_' . $app);
    }

    return str_replace(self::$relativeUrlRoot, self::$apps[$app], url_for($route, $args));
  }

}
