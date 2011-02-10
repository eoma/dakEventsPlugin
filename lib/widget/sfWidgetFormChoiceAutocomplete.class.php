<?php
/**
 * sfWidgetFormChoiceAutocomplete represents a multiple select displayed as an autocomplete input and a list of checkboxes.
 *
 *
 * @package    symfony
 * @subpackage widget
 * @author     Gerald Estadieu <gestadieu@usj.edu.mo>
 * @version    
 */
class sfWidgetFormChoiceAutocomplete extends sfWidgetForm
{
  /**
   * Constructor.
   *
   * Available options:
   *
   *  * choices:            An array of possible choices (required)
   *  * source:             url, array of data or javascript function (required)
   *  * template:           The HTML template to use to render this widget
   *                        The available placeholders are:
   *                          * class
   *                          * autocomplete
   *                          * list
   *
   * @param array $options     An array of options
   * @param array $attributes  An array of default HTML attributes
   *
   * @see sfWidgetForm
   */
  protected function configure($options = array(), $attributes = array())
  {
    parent::configure($options,$attributes);	
    $this->addRequiredOption('choices');
    $this->addRequiredOption('source');

    $this->addOption('multiple', true);
    $this->addOption('list_options',array());
    $this->addOption('help','Search here...');
    $this->addOption('config', '{ }');

    $this->addOption('template',<<<EOF
<div class="%class% ui-widget">
	<div class="%class%_autocomplete">
		%autocomplete%
	</div>
	<div class="%class%_list" id="%id%_list">
		%list%
	</div>
</div>
EOF
);

    $this->addOption('class', 'USJjQueryUIAutocomplete');
    $this->addOption('selectTemplate', 'ui.item.description + "<br />" + ui.item.value');
    $this->addOption('resultTemplate', 'item.description + "<br />" item.value');
    $this->addOption('focusField', 'value'); // Eg. the field in the json reply to use as place holder in the search field

  }

  protected function jQuerySelectMultiple ($name, $selectTemplate, $focusField) {
    $function = <<<EOF
      function(event, ui) {
        if (!$('#%1\$s_'+ui.item.id).length) {
          var ul = $('div#%1\$s_list ul.checkbox_list');
          $('<li><input type="checkbox" checked="checked" id="%1\$s_'+ui.item.id+'" value="'+ui.item.id+'" name="%2\$s"> <label for="%1\$s_'+ui.item.id+'">'+%3\$s+'</label></li>').prependTo(ul);
          $( '#%4\$s' ).val( ui.item.%5\$s );
        }
        $(this).trigger('blur');
        return false;
      }
EOF;

    return sprintf($function, 
      $this->generateId($name),
      $name.'[]',
      $selectTemplate,
      $this->generateId('autocomplete_' . $name), 
      $focusField
    );
  }

  protected function jQuerySelectSingle ($name, $selectTemplate, $focusField) {
    $function = <<<EOF
      function(event, ui) {
        if (!$('#%1\$s_'+ui.item.id).length) {
          var ul = $('div#%1\$s_list ul.checkbox_list');
          $(ul).empty().append('<li><input type="checkbox" checked="checked" id="%1\$s_'+ui.item.id+'" value="'+ui.item.id+'" name="%2\$s"> <label for="%1\$s_'+ui.item.id+'">'+%3\$s+'</label></li>');
          $( '#%4\$s' ).val( ui.item.%5\$s );
        }
        $(this).trigger('blur');
        return false;
      }
EOF;

    return sprintf($function, 
      $this->generateId($name),
      $name,
      $selectTemplate,
      $this->generateId('autocomplete_' . $name), 
      $focusField
    );
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
    if (is_null($value))
    {
      $value = array();
    }
    
    $choices = $this->getOption('choices');
    if ($choices instanceof sfCallable)
    {
      $choices = $choices->call();
    }
    
    $associated = array();
    $unassociated = array();

    if (is_array($value)) {
      foreach ($choices as $key => $option)
      {
        if (in_array(strval($key), $value))
        {
          $associated[$key] = $option;
        }
        else
        {
          $unassociated[$key] = $option;
        }
      }
    } else {
      foreach ($choices as $key => $option)
      {
        if (strval($key) == $value)
        {
          $associated[$key] = $option;
        }
        else
        {
          $unassociated[$key] = $option;
        }
      }
    }

    $associatedWidget = new sfWidgetFormChoice(array_merge($this->getOption('list_options'),array('choices' => $associated, 'multiple' => $this->getOption('multiple'), 'expanded' => true)));

    if ($this->getOption('multiple')) {
      $jQuerySelectFunction = $this->jQuerySelectMultiple($name, $this->getOption('selectTemplate'), $this->getOption('focusField'));
    } else {
      $jQuerySelectFunction = $this->jQuerySelectSingle($name, $this->getOption('selectTemplate'), $this->getOption('focusField'));
    }
	
    return strtr($this->getOption('template'),array(
	'%class%' => $this->getOption('class'),
	'%id%' => $this->generateId($name),
	'%list%' => $associatedWidget->render($name,$value),
	'%autocomplete%' => $this->renderTag('input', array('type' => 'text', 'name' => 'autocomplete_'.$name)) . 
      sprintf(<<<EOF
<script type="text/javascript">
  jQuery(document).ready(function() {
    jQuery('#%1\$s').focus(function(){ $(this).val(''); }).trigger('focus');
    jQuery('#%1\$s').blur(function(){ $(this).val('%2\$s'); }).trigger('blur');
					
    if (!$('div#%3\$s_list ul.checkbox_list').length) {
      $('div#%3\$s_list').append('<ul class="checkbox_list"></ul>');
    }
					
    jQuery('#%1\$s').autocomplete({
      source: %4\$s,
      focus: function( event, ui ) {
        $( "#%1\$s" ).val( ui.item.%8\$s );
        return false;
      },
      select: %6\$s 
    })
    .data( "autocomplete")._renderItem = function (ul, item) {
      return $( "<li></li>" )
        .data( "item.autocomplete", item )
        .append( "<a>" + %7\$s + "</a>" )
        .appendTo( ul );
    };
					
    jQuery('div#%3\$s_list').change(function(e){
      var elt = $(e.target);
      if ($(elt).is(':not(:checked)')) {
        $(elt).parent('li').animate({'backgroundColor':'#fb6c6c'},300); 
      }
      setTimeout(function(){
        if ($(elt).is(':not(:checked)')) {
          $(elt).parent('li').slideUp(300,function() { $(this).remove() });
        } else {
          $(elt).parent('li').css({'backgroundColor':'#fff'});
        }
      },3000);
    });
  });			
</script>
EOF
 ,
        
        $this->generateId('autocomplete_' . $name),
        $this->getOption('help'),
        $this->generateId($name),
        '"' . $this->generateSource() . '"',
        $name . '[]',
        $jQuerySelectFunction,
        $this->getOption('resultTemplate'),
        $this->getOption('focusField')
      )
    ));
  }

  /**
   * Convert source parameter into a valid
   * url if contain a route name
   * 
   * @return string
   */
  protected function generateSource()
  {
    $sourceOption = $this->getOption('source');  
    if ($sourceOption[0] == '@')
    {
      return url_for($sourceOption);
    }
    
    return $sourceOption;
  }
  
  /**
   * Gets the JavaScript paths associated with the widget.
   *
   * @return array An array of JavaScript paths
   */
  // public function getJavascripts()
  // {
  //   return array();
  // }

  /**
   * Gets the stylesheet paths associated with the widget.
   *
   * @return array An array of stylesheet paths
   */
  // public function getStylesheets()
  // {
  //   return array('/css/widgets.css' => 'all');
  // }
}
