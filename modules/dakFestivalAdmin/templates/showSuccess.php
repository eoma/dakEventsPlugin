<?php
include_partial('dakGlobal/assets');
use_helper('I18N', 'Date');

include_partial('dakFestival/showFullFestival', array('festival' => $dak_festival, 'inAdmin' => true, 'pager' => $pager));





