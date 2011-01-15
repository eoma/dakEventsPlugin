<?php 
use_helper('Date');
slot('title', $event['title']);

include_partial('dakEvent/showFullEvent', array('event' => $event));
