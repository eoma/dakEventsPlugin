<?php
include_partial('dakGlobal/assets');
slot('title', $dak_event['title']);

// We use the dakEvent showFullEvent partial as it contains all of the same information
// as we would normally display in the backend with a custom template
include_partial('dakEvent/showFullEvent', array('event' => $dak_event, 'inAdmin' => true));
