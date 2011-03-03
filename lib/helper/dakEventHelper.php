<?php

class dakEventHelper {

  public static function getLocation ($event)
  {
    if ($event['location_id'] > 0) {
      return $event['commonLocation']['name'];
    } else {
      return $event['customLocation'];
    }
  }

}
