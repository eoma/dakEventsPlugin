<?php
use_helper('Date', 'I18N');

$startDatetime = $event['startDate'] . ' ' . $event['startTime'];
$endDatetime = $event['endDate'] . ' ' . $event['endTime'];

if ($event['startDate'] == $event['endDate']) {
  echo __('%1% from %2% to %3%', array('%1%' => format_date($startDatetime, 'p'), '%2%' => format_date($startDatetime, 'HH:mm'), '%3%' => format_date($endDatetime, 'HH:mm')));
} else {
  echo __('from %1% to %2%', array('%1%' => format_datetime($startDatetime, 'p') . ' ' . format_date($startDatetime, 'HH:mm'), '%2%' => format_datetime($endDatetime, 'p') . ' ' . format_date($endDatetime, 'HH:mm')));
}
