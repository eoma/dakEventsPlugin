<?php

class dakEventsUser
{

  static protected $arrangerIds = null;

  static public function methodNotFound(sfEvent $event)
  {
    if (method_exists('dakEventsUser', $event['method']))
    {
      $event->setReturnValue(call_user_func_array(
        array('dakEventsUser', $event['method']),
        array_merge(array($event->getSubject()), $event['arguments'])
      ));
 
      return true;
    }
  }

  static public function isFirstRequest(sfUser $user, $boolean = null)
  {
    if (is_null($boolean))
    {
      return $user->getAttribute('first_request', true);
    }
 
    $user->setAttribute('first_request', $boolean);
  }

  /**
   * Returns array of currently assigned arrangers for a user
   * Most useful if used several different places in a request
   *
   * Requires that you use sfDoctrineGuardPlugin
   */
  static public function getArrangerIds (sfUser $user) {
    if (is_null(self::$arrangerIds)) {
      self::$arrangerIds = Doctrine_Core::getTable('dakArrangerUser')
                           ->getUsersArrangers($user->getGuardUser()->getId());
    }

    return self::$arrangerIds;
  }

}