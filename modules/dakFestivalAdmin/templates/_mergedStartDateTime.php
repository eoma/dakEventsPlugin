<?php
use_helper('Date');
echo format_datetime($dak_festival->getStartDate() . ' ' . $dak_festival->getStartTime());
