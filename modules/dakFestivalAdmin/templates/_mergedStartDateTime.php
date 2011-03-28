<?php
use_helper('Date');
$startDatetime = $dak_festival->getStartDate() . ' ' . $dak_festival->getStartTime();
echo format_date($startDatetime, 'p') . ' ' . format_date($startDatetime, 'HH:mm');
