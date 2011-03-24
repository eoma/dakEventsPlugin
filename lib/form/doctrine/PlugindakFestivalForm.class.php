<?php

/**
 * festival form.
 *
 * @package    kvarteret_events
 * @subpackage form
 * @author     Endre Oma
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PlugindakFestivalForm extends BasedakFestivalForm
{

  protected $scheduledForDeletion = array();

  public function setup()
  {
    parent::setup();

    if (!($this->getOption('currentUser')) instanceof sfGuardSecurityUser) {
      throw new InvalidArgumentException("You must pass a user object as an option to this form!");
    }

    unset($this['created_at'], $this['updated_at']);
    
    $years = range(date('Y'), date('Y') + 3);
    
    $this->widgetSchema['startDate'] = new sfWidgetFormDate(array(
      'format' => '%year%-%month%-%day%',
      'years' => array_combine($years, $years),
    ));

    $startDateJs = "function (date) { wfd_%s_update_linked(date); var t = this;
      $('#dak_festival_endDate_jquery_control').datepicker('option', {mindate: $(t).datepicker('getDate')});
wfd_dak_festival_endDate_update_linked(date); }";

	sfProjectConfiguration::getActive()->loadHelpers(array('Url'));
	$calendarButtonPath = public_path(sfConfig::get('dak_events_module_web_dir') . '/images/calendar.png');

    $this->widgetSchema['startDate'] = new dakWidgetFormJqueryDate(
      array(
        'date_widget' => $this->widgetSchema['startDate'],
        'culture' => $this->getOption('currentUser')->getCulture(),
        'onSelect' => $startDateJs,
        'image' => $calendarButtonPath,
      )
    );

    $this->widgetSchema['endDate'] = new sfWidgetFormDate(array(
      'format' => '%year%-%month%-%day%',
      'years' => array_combine($years, $years),
    ));

    $this->widgetSchema['endDate'] = new dakWidgetFormJqueryDate(
      array(
        'date_widget' => $this->widgetSchema['endDate'],
        'culture' => $this->getOption('currentUser')->getCulture(),
        'image' => $calendarButtonPath,
      )
    );

    $minutes = array();
    for ($i = 0; $i < 60; $i = $i + 5) $minutes[$i] = sprintf("%02d", $i);

    $this->setDefault('startDate', date('Y-m-d', time() + 86400));
    $this->setDefault('startTime', '19:00');
    $this->widgetSchema['startTime']->setOption('minutes', $minutes);
    $this->setDefault('endDate', date('Y-m-d', time() + 86400));
    $this->setDefault('endTime', '21:00');
    $this->widgetSchema['endTime']->setOption('minutes', $minutes);

    $this->setWidget('location_id', new sfWidgetFormDoctrineChoiceNestedSet(array(
      'model'     => 'dakLocation',
      'add_empty' => true,
    )));

    $this->validatorSchema->setPostValidator(
      new sfValidatorAnd(
        array(
          // Add a date validator, require that end date and time is at least 
          // bigger than start date and time
          new sfValidatorCallback(array('callback' => array($this, 'checkStartAndEndDateTime'))),

          // Add location validator, check if either location_id or customLocation is set
          new sfValidatorCallback(array('callback' => array($this, 'checkIfLocationIsSet'))),
        )
      )
    );

    $this->widgetSchema['title']->setAttribute('size', 64);
    $this->widgetSchema['title']->setAttribute('maxlength', 255);

    $this->widgetSchema['leadParagraph'] = new sfWidgetFormCKEditor();
    $editor = $this->widgetSchema['leadParagraph']->getEditor();
    $editor->config['toolbar'] = dakEventsCommon::CKEditorToolbarBlock();
    $editor->config['entities'] = false;

    $this->widgetSchema['description'] = new sfWidgetFormCKEditor();
    $editor = $this->widgetSchema['description']->getEditor();
    $editor->config['toolbar'] = dakEventsCommon::CKEditorToolbarBasic();
    $editor->config['entities'] = false;

    //
    // Embeddable forms
    //

    $this->validatorSchema['arrangers_list']->setOption('required', true);
    $this->widgetSchema['arrangers_list']->setOption('expanded', true);

    if ( ! $this->getOption('currentUser')->hasGroup('admin') ) {
      $user = $this->getOption('currentUser')->getGuardUser();

      $this->widgetSchema['arrangers_list']->setOption('query',
        Doctrine_Core::getTable('dakArranger')->createQuery('a')->select('a.*')->leftJoin('a.users u')->where('u.user_id = ?', $user->getId())
      );
    }
  }

  public function checkIfLocationIsSet ($validator, $values) {
    if (empty($values['customLocation']) && (empty($values['location_id']) || ($values['location_id'] == 0))) {
      $errorMsg = "You must specify either a custom location or a common location";

      $error = new sfValidatorError($validator, $errorMsg);
      throw new sfValidatorErrorSchema($validator, array(
        'customLocation' => $error,
        'location_id' => $error,
      ));
    }

    return $values;
  }

  public function checkStartAndEndDateTime($validator, $values) {
    $startDate = $values['startDate'];
    $startTime = $values['startTime'];
    $endDate = $values['endDate'];
    $endTime = $values['endTime'];

    $startTimestamp = strtotime($startDate . ' ' . $startTime);
    $endTimestamp = strtotime($endDate . ' ' . $endTime);

    if ($startTimestamp < time()) {
      $errorMsg = "You can't set start date and time to the past";

      $error = new sfValidatorError($validator, $errorMsg);
      throw new sfValidatorErrorSchema($validator, array(
        'startDate' => $error,
        'startTime' => $error,
      ));
    }

    if ($endTimestamp < $startTimestamp) {
      $errorMsg = "End date and time must be later than start date and time";

      $error = new sfValidatorError($validator, $errorMsg);
      throw new sfValidatorErrorSchema($validator, array(
        'endDate' => $error,
        'endTime' => $error,
      ));
    }

    return $values;
  }
}
