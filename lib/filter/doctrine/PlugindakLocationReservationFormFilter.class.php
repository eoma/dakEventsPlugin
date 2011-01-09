<?php

/**
 * locationReservation filter form.
 *
 * @package    kvarteret_events
 * @subpackage filter
 * @author     Endre Oma
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PlugindakLocationReservationFormFilter extends BasedakLocationReservationFormFilter
{
  public function configure()
  {

    if (!($this->getOption('currentUser')) instanceof sfGuardSecurityUser) {
      throw new InvalidArgumentException("You must pass a user object as an option to this form!");
    }

    $statusChoices = array('' => '') + locationReservation::getStatusChoices();
    $this->widgetSchema['status'] = new sfWidgetFormChoice( array( 'choices' => $statusChoices ) );
    $this->validatorSchema['status'] = new sfValidatorChoice( array( 'required' => false, 'choices' => array_keys($statusChoices)) );

    $yesOrNoChoices = array(
      '' => 'Yes or no',
      1 => 'Yes',
      0 => 'No',
    );

    $yesOrNoWidgetSettings = array('choices' => $yesOrNoChoices);

    $yesOrNoValidatorSettings = array(
      'required' => false,
      'choices' => array_keys($yesOrNoChoices),
    );

    $this->widgetSchema['hasLightSound'] = new sfWidgetFormChoice($yesOrNoWidgetSettings);
    $this->validatorSchema['hasLightSound'] = new sfValidatorChoice($yesOrNoValidatorSettings);
    
    $this->widgetSchema['hasPhotography'] = new sfWidgetFormChoice($yesOrNoWidgetSettings);
    $this->validatorSchema['hasPhotography'] = new sfValidatorChoice($yesOrNoValidatorSettings);
    
    $this->widgetSchema['hasCatering'] = new sfWidgetFormChoice($yesOrNoWidgetSettings);
    $this->validatorSchema['hasCatering'] = new sfValidatorChoice($yesOrNoValidatorSettings);
  }

  public function getFields()
  {
    $fields = parent::getFields();
    $fields['hasLightSound'] = 'hasLightSound';
    $fields['hasPhotography'] = 'hasPhotography';
    $fields['hasCatering'] = 'hasCatering';
    $fields['status'] = 'ForeignKey'; // A small trick to make symfony filter values from choice list.

    return $fields;
  }

  public function addHasLightSoundColumnQuery($query, $field, $value)
  {
    return $this->addHasRequirementColumnQuery($query, $field, $value);
  }

  public function addHasPhotographyColumnQuery($query, $field, $value)
  {
    return $this->addHasRequirementColumnQuery($query, $field, $value);
  }

  public function addHasCateringColumnQuery($query, $field, $value)
  {
    return $this->addHasRequirementColumnQuery($query, $field, $value);
  }

  public function addHasRequirementColumnQuery($query, $field, $value)
  {
    if ($field == 'hasLightSound') $relation = 'requirementLightSound';
    if ($field == 'hasPhotography') $relation = 'requirementPhotography';
    if ($field == 'hasCatering') $relation = 'requirementCatering';

    $rootAlias = $query->getRootAlias();
    $fullKey = $rootAlias . '.' . $relation;

    if ($value == 1)
    {
      $query->leftJoin($fullKey)->andWhere( $fullKey . '.locationReservation_id is not null');
    }
    else
    {
      $query->leftJoin($fullKey)->andWhere($fullKey . '.locationReservation_id is null');
    }

    return $query;
  }
}
