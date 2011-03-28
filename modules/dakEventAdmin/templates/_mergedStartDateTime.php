<?php
use_helper('Date');
$combinedDate = $dak_event->getStartDate() . ' ' . $dak_event->getStartTime();
echo format_date($combinedDate, 'p') . ' ' .  format_date($combinedDate, 'HH:mm');
