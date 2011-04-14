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

    // Set default start and end date to the next day
    $this->setDefault('accessDate', date('Y-m-d', time() + 86400));
    $this->setDefault('accessTime', '19:00');
    $this->setDefault('startDate', date('Y-m-d', time() + 86400));
    $this->setDefault('startTime', '19:00');
    $this->setDefault('endDate', date('Y-m-d', time() + 86400));
    $this->setDefault('endTime', '21:00');

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
    $name = 'activate' . ucfirst($name);
    $this->widgetSchema[$name] = new sfWidgetFormInputCheckbox();
    $this->validatorSchema[$name] = new sfValidatorBoolean();
    
    if ($checked == true)
    {
      $this->widgetSchema[$name]->setDefault(true);
    }
  }
  
  public function doBind ( array $values ) 
  {
    
    $this->checkIfActivatedRequirement('embedRequirementCatering', 'dakRequirementCatering', $values);
    $this->checkIfActivatedRequirement('embedRequirementLightSound', 'dakRequirementLightSound', $values);
    $this->checkIfActivatedRequirement('embedRequirementPhotography', 'dakRequirementPhotography', $values);

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
