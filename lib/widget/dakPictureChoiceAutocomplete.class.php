<?php

class dakPictureChoiceAutocomplete extends sfWidgetFormChoiceBase
{

  protected static $frontendLink = null;
  protected static $relativeUrlRoot = null;

  public static function jQueryUISelectTemplate () {
    return "'<img src=\"' + ui.item.thumbUrl + '\" width=\"' + ui.item.thumbWidth + '\" height=\"' + ui.item.thumbHeight +'\" /><span>' + ui.item.description + '</span>'";
  }

  public static function jQueryUIResultTemplate () {
    return str_replace('ui.', '', self::jQueryUISelectTemplate(true));
  }

  protected function renderSingle ($name, $value = null, $attributes = array(), $errors = array())
  {
    $choices = $this->getChoices();

    if (count($choices) == 0) {
      $output = $this->renderTag('input', array('type' => 'hidden', 'name' => $name, 'value' => ''));
    } else {

      $o = array_shift($choices);

      $thumbRouteArgs = array(
        'type' => 'dakPicture',
        'format' => 'list',
        'id' => $o['id'],
      );

      $output = $this->renderTag('input', array('type' => 'hidden', 'name' => $name, 'value' => $o['id'], 'id' => $this->generateId($name.'_'.$o['id'])));
      $output .= '<label for="' . $this->generateId($name) . '_' . $o['id'] . '">';
      // Begin custom markup

      $sizes = ImageHelper::TransformSize($thumbRouteArgs['format'], $o['width'], $o['height']);
      $imgSrc = str_replace(self::$relativeUrlRoot, self::$frontendLink, url_for('dak_thumb', $thumbRouteArgs));

      $output .= '<img src="' . $imgSrc . '" width="'. $sizes['width'] .'" height="'. $sizes['height'] .'" alt="'. $o['description'] .'" />';
      $output .= '<span>' . $o['description'] . '</span>';

      // End custom markup
      $output .= '</label>';
    }

    return '<ul class="checkbox_list"><li>' . $output . '</li></ul>';
  }

  protected function renderMultiple ($name, $value = null, $attributes = array(), $errors = array())
  {
    // Assumes $name has an [] at it's end. Assumes all values exist

    $outputs = array();

    $choices = $this->getChoices();

    //return var_dump($choices);

    $thumbRouteArgs = array(
      'type' => 'dakPicture',
      'format' => 'list'
    );

    //foreach ($choices as ‭$k => $o) {
    $len = count($choices);
    $keys = array_keys($choices);
    
    for ( $i = 0; $i < $len; $i++) {
      $k = $keys[$i];
      $o = $choices[$k];

      $output = '<li>';
      $output .= '<input type="checkbox" checked="checked" id="' . $this->generateId($name) . '_' . $o['id'] .'" value="' . $o['id'] . '" name="'. $name .'" />';
      $output .= '<label for="' . $this->generateId($name) . '_' . $o['id'] . '">';
      
      // Start custom markup here

      $sizes = ImageHelper::TransformSize($thumbRouteArgs['format'], $o['width'], $o['height']);
      $thumbRouteArgs['id'] = $o['id'];
      $imgSrc = str_replace(self::$relativeUrlRoot, self::$frontendLink, url_for('dak_thumb', $thumbRouteArgs));

      $output .= '<img src="' . $imgSrc . '" width="'. $sizes['width'] .'" height="'. $sizes['height'] .'" alt="'. $o['description'] .'" />';
      $output .= '<span>' . $o['description'] . '</span>';

      // End custom markup
      
      $output .= '</label>';
      $output .= '</li>';

      $outputs[] = $output;
    }

    return '<ul class="checkbox_list">' . implode("\n", $outputs) . '</ul>';
  }

  /**
   * Constructor.
   *
   * Available options:
   *
   *  * choices:         An array of possible choices (required)
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);

    $this->addOption('multiple', false);
    
    if (is_null(self::$frontendLink)) {
      self::$frontendLink = sfConfig::get('app_applicationLinks_frontend');
    }
    
    if (is_null(self::$relativeUrlRoot)) {
      if (sfConfig::get('sf_no_script_name')) {
        self::$relativeUrlRoot = sfContext::getInstance()->getRequest()->getRelativeUrlRoot();
      } else {
        self::$relativeUrlRoot = sfContext::getInstance()->getRequest()->getScriptName();
      }
    }
  }

  /**
   * Renders the widget.
   *
   * @param  string $name        The element name
   * @param  string $value       The value selected in this widget
   * @param  array  $attributes  An array of HTML attributes to be merged with the default HTML attributes
   * @param  array  $errors      An array of errors for the field
   *
   * @return string An HTML tag string
   *
   * @see sfWidgetForm
   */
  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    if (isset($attributes['multiple'])) {
      return $this->renderMultiple($name, $value, $attributes, $errors);
    } else {
      return $this->renderSingle($name, $value, $attributes, $errors);
    }

  }

}
