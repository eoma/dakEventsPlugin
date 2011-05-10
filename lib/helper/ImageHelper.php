<?php 

class ImageHelper
{
  protected static $formats = array();
  
  /**
   * This function will help you compute new image sizes
   * when using sfImageTransformExtraPlugin and the transform is proportional
   * 
   * @param $format string format name
   * @param $origWidth integer original width of image
   * @param $origHeight integer original height of image
   * @return array
   */
  public static function TransformSize ($format, $origWidth = 0, $origHeight = 0) {
	if (empty(self::$formats)) {
      // This will fetch all defined thumbnailing formats defined in
      // various projects', plugins' and applications' thumbnailing.yml for
      // sfImageTransformExtraPlugin.
      self::$formats = sfConfig::get('thumbnailing_formats');
    }

    $height = null;
    $width = null;

    if (array_key_exists($format, self::$formats) && ($origHeight > 0) && ($origWidth > 0)) {
      $first = self::$formats[$format]['transformations'][0];
      $param = $first['param'];

      if (in_array($first['transformation'], array('resize', 'thumbnail')) && 
          ($param['proportional'] == true)) {

        $transformRatio = $param['height'] / $param['width'];
        $origRatio = $origHeight / $origWidth;

        if ($origRatio > $transformRatio) {
          // The transform image's width must be shrinked
          $height = $param['height'];
          $width = (int) round($param['width'] * $transformRatio / $origRatio);
        } else if ($origRatio < $transformRatio) {
          // The transform image's height must be shrinked
          $width = $param['width'];
          $height = (int) round($param['height'] * $origRatio / $transformRatio);
        } else {
          $height = $param['height'];
          $width = $param['width'];
        }

        if (isset($param['inflate']) && ($param['inflate'] == false) && ($origWidth < $param['width']) && ($origHeight < $param['height'])) {
          $height = $origHeight;
          $width = $origWidth;
	}
      }
    }
    
    return array('height' => $height, 'width' => $width);
  }

  /**
   * Returns an associative array of transform formats
   * and their final resulting image size limits
   *
   * @return array
   */
  public static function FormatList () {
    if (empty(self::$formats)) {
      // This will fetch all defined thumbnailing formats defined in
      // various projects', plugins' and applications' thumbnailing.yml for
      // sfImageTransformExtraPlugin.
      self::$formats = sfConfig::get('thumbnailing_formats');
    }

    $list = array();

    foreach (self::$formats as $format => $data) {

      if (!isset($data['transformations'][0]['param'])) {
        continue;
      }

      $param = $data['transformations'][0]['param'];

      if (!isset($param['height']) || !isset($param['width'])) {
        continue;
      }

      $tmp = array(
        'height' => $param['height'],
        'width' => $param['width'],
      );

      $list[$format] = $tmp;
    }

    return $list;
  }
}
