<?php
use_helper('Date');
echo format_datetime($festival->getStartDate() . ' ' . $festival->getStartTime());
