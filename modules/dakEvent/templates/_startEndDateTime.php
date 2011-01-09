<?php
use_helper('Date', 'I18N');
if ($event['startDate'] == $event['endDate']) {
  echo __('%1% from %2% to %3%', array('%1%' => format_date($event['startDate']), '%2%' => format_date($event['startDate'] . ' ' . $event['startTime'], 'HH:mm'), '%3%' => format_date($event['endDate'] . ' ' . $event['endTime'], 'HH:mm')));
} else {
  echo __('from %1% to %2%', array('%1%' => format_datetime($event['startDate']. ' ' . $event['startTime']), '%2%' => format_datetime($event['endDate'] . ' ' . $event['endTime'])));
}
