<?php
if (!isset($format)) {
  $format = 'list';
}
$picArgs = array(
  'format' => $format,
  'type' => 'dakPicture',
  'id' => $picture['id'],
);

echo image_tag(url_for('dak_thumb', $picArgs),
  array(
    'alt' => $picture['description'],
  )
);
