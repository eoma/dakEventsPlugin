<?php
use_helper('Date');
$startDatetime = $event['startDate'] . ' ' . $event['startTime'];
echo format_date($startDatetime, 'p') . ' ' . format_date($startDatetime, 'HH:mm');
