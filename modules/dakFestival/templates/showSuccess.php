<?php
include_partial('dakGlobal/assets');
use_helper('I18N', 'Date');
slot('title', $festival['title'] . ' - ' . __('Festival'));

include_partial('dakFestival/showFullFestival', array('festival' => $festival, 'pager' => $pager));


