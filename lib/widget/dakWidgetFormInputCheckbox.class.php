<?php

class dakWidgetFormInputCheckbox extends sfWidgetFormInputCheckbox
{

  /**
   * Constructor.
   *
   * Available options:
   *
   *  - value_attribute_value: The "value" attribute value to set for the checkbox
   *
   * @param array  $options     An array of options
   * @param array  $attributes  An array of default HTML attributes
   *
   * @see sfWidgetFormInput
   */
  public function __construct($options = array(), $attributes = array())
  {
    $this->addOption('javascript', '');

    parent::__construct($options, $attributes);
  }


  /**
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetFormInput
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options, $attributes);
  }

  public function render($name, $value = null, $attributes = array(), $errors = array())
  {
    $input = parent::render($name, $value, $attributes, $errors);

	$javascript = $this->getOption('javascript');

    if ( ! empty($javascript) && is_string($javascript) ) {
      $input .= $this->renderContentTag('script', $this->getOption('javascript'), array('type' => 'text/javascript'));
    }

    return $input;
  }

}
