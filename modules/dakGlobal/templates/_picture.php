<?php
use_helper('Image', 'UrlExtra');

if (!isset($format)) {
  $format = 'list';
}

$imgOptions = array(
  'alt' => $picture['description'],
);

if (isset($class)) {
  $imgOptions['class'] = strval($class);
}

$imgOptions += ImageHelper::TransformSize($format, $picture['width'], $picture['height']);

$picArgs = array(
  'format' => $format,
  'type' => 'dakPicture',
  'id' => $picture['id'],
);

$imageFormats = ImageHelper::FormatList();

$extension = substr($picture['mime_type'], 6);

if (in_array($picture['mime_type'], $imageFormats[$format]['mime_type'])) {
  $picArgs['sf_format'] = $extension;
}

echo image_tag(UrlExtraHelper::url_for_app('frontend', 'dak_thumb', $picArgs), $imgOptions);
