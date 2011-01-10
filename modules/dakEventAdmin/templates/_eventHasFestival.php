<?php
use_helper('Date');
if ($dak_event->relatedExists('festival')) {
  echo 'Part of ' . link_to($dak_event->getFestival()->getTitle() . ' ' . format_date($dak_event->getFestival()->getStartDate()), '@dak_festival_admin_show?id=' . $dak_event->getFestival()->getId()) . '.<br />';
}
