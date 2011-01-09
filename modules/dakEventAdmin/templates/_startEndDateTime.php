<?php
if ($event['startDate'] == $event['endDate']) {
  echo format_date($event['startDate']) . ' from ' . $event['startTime'] . ' to ' . $event['endTime'];
} else {
  echo 'from ' . format_date($event['startDate']) . ' ' . $event['startTime'] . ' to ' . format_date($event['endDate']) . ' ' . $event['endTime'];
}
