<?php
use_helper('Date');
echo format_datetime($dak_event->getStartDate() . ' ' . $dak_event->getStartTime());
