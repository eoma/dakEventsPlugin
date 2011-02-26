<?php

/**
 * Specialized class for creating standardized iCalendar events and collections
 */

class myICalendar extends vcalendar {
  public function __construct() {
    $config = array();
    if ( ! empty($_SERVER['HTTP_HOST']) ) {
      $config['unique_id'] = $_SERVER['HTTP_HOST'];
    } else {
      $config['unique_id'] = $_SERVER['SERVER_NAME'];
    }

    parent::__construct($config);
    
    if ( ! function_exists ('url_for') ) {
      ProjectConfiguration::getActive()->loadHelpers('Url');
	}
	
	$this->setProperty('method', 'PUBLISH');
  }

  /**
   * Creates an event for use in the current calendar
   */
  public function createICalEvent ($event) {
    $e = new vevent();

    $iCalDateFormat = "Ymd\THis";

    $startTimestamp = strtotime($event['startDate'] . ' ' . $event['startTime']);
    $endTimestamp = strtotime($event['endDate'] . ' ' . $event['endTime']);

    $e->setProperty('summary', strip_tags($event['title']));
    $e->setProperty('description', strip_tags($event['leadParagraph']));

    if ($event['location_id'] > 0) {
      $e->setProperty('location', strip_tags($event['commonLocation']['name']));
    } else {
      $e->setProperty('location', strip_tags($event['customLocation']));
    }

    $e->setProperty('dtstart', date($iCalDateFormat, $startTimestamp));
    $e->setProperty('dtend', date($iCalDateFormat, $endTimestamp));
    $e->setProperty('dtstamp', date($iCalDateFormat, strtotime($event['created_at'])));
    $e->setProperty('last-modified', date($iCalDateFormat, strtotime($event['updated_at'])));
    
    //$e->setProperty('url', url_for('@dak_event_show?id=' . $event['id'], true));
    //$e->setProperty('geo', 1.234, 4.234);

    $e->setProperty('uid', 'event-' . md5($event['created_at'] . ' ' . $event['id'])  . '@' . $this->unique_id);

    $this->addComponent($e);
  }
}
