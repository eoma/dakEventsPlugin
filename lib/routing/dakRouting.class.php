<?php

class dakRouting
{

  static public function addRouteForEventAdmin (sfEvent $event)
  {
    $event->getSubject()->prependRoute('dak_event_admin', new sfDoctrineRouteCollection(array(
      'name'                => 'dak_event_admin',
      'model'               => 'dakEvent',
      'module'              => 'dakEventAdmin',
      'prefix_path'         => 'event',
      'with_wildcard_routes' => true,
      'collection_actions'  => array('filter' => 'post', 'batch' => 'post'),
      'requirements'        => array(),
    )));
  }

  static public function addRouteForFestivalAdmin (sfEvent $event)
  {
    $event->getSubject()->prependRoute('dak_festival_admin', new sfDoctrineRouteCollection(array(
      'name'                => 'dak_festival_admin',
      'model'               => 'dakFestival',
      'module'              => 'dakFestivalAdmin',
      'prefix_path'         => 'festival',
      'with_wildcard_routes' => true,
      'collection_actions'  => array('filter' => 'post', 'batch' => 'post'),
      'requirements'        => array(),
    )));
  }

  static public function addRouteForArrangerAdmin (sfEvent $event)
  {
    $event->getSubject()->prependRoute('dak_arranger_admin', new sfDoctrineRouteCollection(array(
      'name'                => 'dak_arranger_admin',
      'model'               => 'dakArranger',
      'module'              => 'dakArrangerAdmin',
      'prefix_path'         => 'arranger',
      'with_wildcard_routes' => true,
      'collection_actions'  => array('filter' => 'post', 'batch' => 'post'),
      'requirements'        => array(),
    )));
  }

  static public function addRouteForCategoryAdmin (sfEvent $event)
  {
    $event->getSubject()->prependRoute('dak_category_admin', new sfDoctrineRouteCollection(array(
      'name'                => 'dak_category_admin',
      'model'               => 'dakCategory',
      'module'              => 'dakCategoryAdmin',
      'prefix_path'         => 'category',
      'with_wildcard_routes' => true,
      'collection_actions'  => array('filter' => 'post', 'batch' => 'post'),
      'requirements'        => array(),
    )));
  }

  static public function addRouteForLocationAdmin (sfEvent $event)
  {
    $event->getSubject()->prependRoute('dak_location_admin', new sfDoctrineRouteCollection(array(
      'name'                => 'dak_location_admin',
      'model'               => 'dakLocation',
      'module'              => 'dakLocationAdmin',
      'prefix_path'         => 'location',
      'with_wildcard_routes' => true,
      'collection_actions'  => array('filter' => 'post', 'batch' => 'post'),
      'requirements'        => array(),
    )));
  }

  static public function addRouteForLocationReservationAdmin (sfEvent $event)
  {
    $event->getSubject()->prependRoute('dak_location_reservation_admin', new sfDoctrineRouteCollection(array(
      'name'                => 'dak_location_reservation_admin',
      'model'               => 'dakLocationReservation',
      'module'              => 'dakLocationReservationAdmin',
      'prefix_path'         => 'location_reservation',
      'with_wildcard_routes' => true,
      'collection_actions'  => array('filter' => 'post', 'batch' => 'post'),
      'requirements'        => array(),
    )));
  }
  
  static public function addRouteForPictureAdmin (sfEvent $event)
  {
    $event->getSubject()->prependRoute('dak_picture_admin', new sfDoctrineRouteCollection(array(
      'name'                => 'dak_picture_admin',
      'model'               => 'dakPicture',
      'module'              => 'dakPictureAdmin',
      'prefix_path'         => 'picture',
      'with_wildcard_routes' => true,
      'collection_actions'  => array('filter' => 'post', 'batch' => 'post'),
      'requirements'        => array(),
    )));
  }
}
