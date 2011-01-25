<?php
use_helper('Image');

if (!isset($format)) {
  $format = 'list';
}

$imgOptions = array(
  'alt' => $picture['description'],
);

$imgOptions += ImageHelper::TransformSize($format, $picture['width'], $picture['height']);

$picArgs = array(
  'format' => $format,
  'type' => 'dakPicture',
  'id' => $picture['id'],
);

echo image_tag(url_for('dak_thumb', $picArgs), $imgOptions);
