<?php

if ($dak_event['primaryPicture_id'] > 0) {
  include_partial('dakGlobal/picture', array('picture' => $dak_event['primaryPicture'], 'format' => 'listSmall', 'class' => 'eventPicture'));
}
