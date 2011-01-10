<?php
use_helper('Date');
if ($event->relatedExists('festival')) {
  echo 'Part of ' . link_to($event->getFestival()->getTitle() . ' ' . format_date($event->getFestival()->getStartDate()), '@dak_festival_admin_show?id=' . $event->getFestival()->getId()) . '.<br />';
}
