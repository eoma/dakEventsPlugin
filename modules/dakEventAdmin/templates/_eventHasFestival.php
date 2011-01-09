<?php
use_helper('Date');
if ($event->relatedExists('festival')) {
  echo 'Part of ' . link_to($event->getFestival()->getTitle() . ' ' . format_date($event->getFestival()->getStartDate()), '@festival_edit?id=' . $event->getFestival()->getId()) . '.<br />';
}
