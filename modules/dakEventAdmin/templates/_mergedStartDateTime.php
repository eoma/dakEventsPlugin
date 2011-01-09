<?php
use_helper('Date');
echo format_datetime($event->getStartDate() . ' ' . $event->getStartTime());
