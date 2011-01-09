<?php
if ($event['location_id'] > 0) {
  echo link_to($event['recurringLocation'], '@location_show?id=' . $event['location_id']);
} else {
  echo $event['customLocation'];
}
