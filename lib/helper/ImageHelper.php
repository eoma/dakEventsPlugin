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

        if (($param['height'] / $param['width']) > ($origHeight / $origWidth)) {
          $height = (int) round($param['width'] * $origHeight / $origWidth);
          $width = $param['width'];
          
          if ($height > $param['height']) {
            $width = (int) round($param['width'] * $param['height'] / $height);
            $height = $param['height'];
          }
          
        } else {
          $height = $param['height'];
          $width = (int) round($param['height'] * $origWidth / $origHeight);
          
          if ($width > $param['width']) {
            $height = (int) round($param['height'] * $param['width'] / $width);
            $width = $param['width'];
          }
        }
      }
    }
    
    return array('height' => $height, 'width' => $width);
  }
}
