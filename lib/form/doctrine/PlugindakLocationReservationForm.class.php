<?php

/**
 * locationReservation form.
 *
 * @package    kvarteret_events
 * @subpackage form
 * @author     Endre Oma
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PlugindakLocationReservationForm extends BasedakLocationReservationForm
{

  protected $scheduledRequirementsForDeletion = array();

  public function setup()
  {
    parent::setup();

    unset( $this['created_at'], $this['updated_at'], $this['user_id'] );
    
    if (!($this->getOption('currentUser')) instanceof sfGuardSecurityUser) {
      throw new InvalidArgumentException("You must pass a user object as an option to this form!");
    }

    $years = range(date('Y'), date('Y') + 3);

    sfProjectConfiguration::getActive()->loadHelpers(array('Url'));
	$calendarButtonPath = public_path(sfConfig::get('dak_events_module_web_dir') . '/images/calendar.png');

    $this->widgetSchema['accessDate'] = new sfWidgetFormDate(array(
      'format' => '%year%-%month%-%day%',
      'years' => array_combine($years, $years),
    ));

    $accessDateJs = "function (date) {\n"
                 . "	wfd_%s_update_linked(date);\n"
                 . "	var t = this;\n"
                 . "	$('#dak_location_reservation_startDate_jquery_control').datepicker('option', {mindate: $(t).datepicker('getDate')});\n"
                 . "	wfd_dak_location_reservation_startDate_update_linked(date);\n"
                 . "	$('#dak_location_reservation_endDate_jquery_control').datepicker('option', {mindate: $(t).datepicker('getDate')});\n"
                 . "	wfd_dak_location_reservation_endDate_update_linked(date);\n"
                 . "}\n";

    $this->widgetSchema['accessDate'] = new dakWidgetFormJqueryDate(
      array(
        'date_widget' => $this->widgetSchema['accessDate'],
        'culture' => $this->getOption('currentUser')->getCulture(),
        'image' => $calendarButtonPath,
        'onSelect' => $accessDateJs,
      )
    );

    $this->widgetSchema['startDate'] = new sfWidgetFormDate(array(
      'format' => '%year%-%month%-%day%',
      'years' => array_combine($years, $years),
    ));

    $startDateJs = "function (date) {\n"
                 . "	wfd_%s_update_linked(date); var t = this;\n"
                 . "	$('#dak_location_reservation_endDate_jquery_control').datepicker('option', {mindate: $(t).datepicker('getDate')});\n"
                 . "	wfd_dak_location_reservation_endDate_update_linked(date);\n"
                 . "}";

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

    // Set default start and end date to the next day
    $this->setDefault('accessDate', date('Y-m-d', time() + 86400));
    $this->setDefault('accessTime', '14:00');
    $this->widgetSchema['accessTime']->setOption('minutes', $minutes);
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

    $this->widgetSchema['status'] = new sfWidgetFormSelect( array( 'choices' => dakLocationReservation::getStatusChoices() ));
    $this->validatorSchema['status'] = new sfValidatorChoice( array( 'choices' => array_keys(dakLocationReservation::getStatusChoices()) ) );

    if ( ! $this->isNew() )
    {
      
      $defaultDateTime = array(
        'date' => $this->getObject()->getStartDate(),
        'time' => $this->getObject()->getStartTime(),
      );

      $defaultRequirementOptions = array(
        'hideLocationReservation' => true,
      );

      // IMPORTANT!!! When embedding forms, NEVER give them a name that
      // is equal to a relationship name for the model used in this form.
      // See end of http://trac.symfony-project.org/ticket/4935

      // Light and sound

      $lightSoundOptions = $defaultRequirementOptions + array('soundCheck' => $defaultDateTime, 'getIn' => $defaultDateTime);

      if ($this->getObject()->relatedExists('requirementLightSound'))
      {
        $this->addActivateCheckbox('embedRequirementLightSound', true);
        $this->embedRelation('requirementLightSound as embedRequirementLightSound', 'dakRequirementLightSoundForm', array('options' => $lightSoundOptions));
      }
      else
      {
        $this->addActivateCheckbox('embedRequirementLightSound');
        $requirementLightSoundForm = new dakRequirementLightSoundForm(array(), $lightSoundOptions);
        $this->embedForm('embedRequirementLightSound', $requirementLightSoundForm);
      }

      // Photography

      $photographyOptions = $defaultRequirementOptions + array('meetAt' => $defaultDateTime);

      if ($this->getObject()->relatedExists('requirementPhotography'))
      {
        $this->addActivateCheckbox('embedRequirementPhotography', true);
        $this->embedRelation('requirementPhotography as embedRequirementPhotography', 'dakRequirementPhotographyForm', array('options' => $photographyOptions));
      }
      else
      {
        $this->addActivateCheckbox('embedRequirementPhotography');
        $requirementPhotographyForm = new dakRequirementPhotographyForm(array(), $photographyOptions);
        $this->embedForm('embedRequirementPhotography', $requirementPhotographyForm);
      }

      // Catering

      $cateringOptions = $defaultRequirementOptions + array('servedAt' => $defaultDateTime);

      if ($this->getObject()->relatedExists('requirementCatering'))
      {
        $this->addActivateCheckbox('embedRequirementCatering', true);
        $this->embedRelation('requirementCatering as embedRequirementCatering', 'dakRequirementCateringForm', array('options' => $cateringOptions));
      }
      else
      {
        $this->addActivateCheckbox('embedRequirementCatering');
        $requirementCateringForm = new dakRequirementCateringForm(array(), $cateringOptions);
        $this->embedForm('embedRequirementCatering', $requirementCateringForm);
      }

    }

  }
  
  public function addActivateCheckbox($name, $checked = false)
  {
    $checkboxName = 'activate' . ucfirst($name);
    $this->widgetSchema[$checkboxName] = new dakWidgetFormInputCheckbox();

    $this->validatorSchema[$checkboxName] = new sfValidatorBoolean();

    if ($checked == true)
    {
      $this->widgetSchema[$checkboxName]->setDefault(true);
    }

    $this->widgetSchema[$checkboxName]->setOption('javascript', '$(document).ready(function() {
  if ($("input#dak_location_reservation_'. $checkboxName .':not(:checked)").length > 0) {
    $(".sf_admin_form_field_'. $name .'").hide();
  }
  $("#dak_location_reservation_'. $checkboxName .'").click(function(e) {
    $(".sf_admin_form_field_'. $name .'").toggle();
  });
});');

  }
  
  public function doBind ( array $values ) 
  {
    
    $this->checkIfActivatedRequirement('embedRequirementCatering', 'requirementCatering', $values);
    $this->checkIfActivatedRequirement('embedRequirementLightSound', 'requirementLightSound', $values);
    $this->checkIfActivatedRequirement('embedRequirementPhotography', 'requirementPhotography', $values);

    parent::doBind($values);
  }


  /**
   * Will check if embedded requirement is activated or not and whether it already exists
   * Will delete relation if not activated and relation exists.
   */
  protected function checkIfActivatedRequirement($name, $relationName, array &$values)
  {
    $activateName = 'activate' . ucfirst($name);

    // Since we've hidden the locationReservation_id in the embedded form, we
    // must set its value here.
    $values[$name]['locationReservation_id'] = $this->getObject()->getId();

    if (!isset($values[$activateName]) || ($values[$activateName] == false))
    {
      if ($this->getObject()->relatedExists($relationName)) 
      {
        $this->scheduledRequirementsForDeletion[] = array( 'formName' => $name, 'relationName' => $relationName);
      }
      else
      {
        unset($this[$name], $values[$name]);
      }
    }
  }
  
  protected function doUpdateObject($values)
  {

    if ($this->isNew())
    {
      $this->getObject()->setUserId($this->getOption('currentUser')->getGuardUser()->getId());
    }

    if (count($this->scheduledRequirementsForDeletion))
    {
      foreach ($this->scheduledRequirementsForDeletion as $names)
      {
        // We'll delete objects marked for deletion
        $relationName = $names['relationName'];
        $formName = $names['formName']; 

        unset($values[$formName]);
        unset($this[$formName]);

        // Delete the object
        // $this->object->delete(); // unnecessary
        unset($this->object->$relationName);
      }
    }
 
    return parent::doUpdateObject( $values );
  }
}
