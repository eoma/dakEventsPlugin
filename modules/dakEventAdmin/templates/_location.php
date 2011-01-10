<?php
if ($dak_event['location_id'] > 0) {
  echo link_to($dak_event['commonLocation'], '@dak_location_admin_show?id=' . $dak_event['location_id']);
} else {
  echo $dak_event['customLocation'];
}
