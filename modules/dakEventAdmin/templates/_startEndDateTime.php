<?php
if ($dak_event['startDate'] == $dak_event['endDate']) {
  echo format_date($dak_event['startDate']) . ' from ' . $dak_event['startTime'] . ' to ' . $dak_event['endTime'];
} else {
  echo 'from ' . format_date($dak_event['startDate']) . ' ' . $dak_event['startTime'] . ' to ' . format_date($dak_event['endDate']) . ' ' . $dak_event['endTime'];
}
