<?php
use_helper('Image', 'UrlExtra');

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

echo image_tag(UrlExtraHelper::url_for_app('frontend', 'dak_thumb', $picArgs), $imgOptions);
