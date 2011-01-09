<?php
use_helper('Date');
if ( ! is_null($event['festival']) ) {
  echo __('Part of') . ' ' . link_to($event['festival']['title'] . ' ' . format_date($event['festival']['startDate']), '@dak_festival_show?id=' . $event['festival_id']) . '.<br />';
}
