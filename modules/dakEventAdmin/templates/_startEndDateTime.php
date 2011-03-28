<?php
$startDatetime = $dak_event['startDate'] . ' ' . $dak_event['startTime'];
$endDatetime = $dak_event['endDate'] . ' ' . $dak_event['endTime'];

if ($dak_event['startDate'] == $dak_event['endDate']) {
  echo format_date($startDatetime, 'p') . ' from ' . format_date($startDatetime, 'HH:mm') . ' to ' . format_date($endDatetime, 'HH:mm');
} else {
  echo 'from ' . format_date($startDatetime, 'p') . ' ' . format_date($startDatetime, 'HH:mm') . ' to ' . format_date($startDatetime, 'p') . ' ' . format_date($startDatetime, 'HH:mm');
}
