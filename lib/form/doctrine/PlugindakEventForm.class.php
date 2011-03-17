<?php

/**
 * event form.
 *
 * @package    kvarteret_events
 * @subpackage form
 * @author     Endre Oma
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PlugindakEventForm extends BasedakEventForm
{
  public function setup()
  {
    parent::setup();

    if (!($this->getOption('currentUser')) instanceof sfGuardSecurityUser) {
      throw new InvalidArgumentException("You must pass a user object as an option to this form!");
    }

    unset(
      $this['created_at'], $this['updated_at'], $this['user_id']
    );

    $years = range(date('Y'), date('Y') + 3);

    $this->widgetSchema['startDate'] = new sfWidgetFormDate(array(
      'format' => '%year%-%month%-%day%',
      'years' => array_combine($years, $years),
    ));

    $startDateJs = "function (date) { wfd_%s_update_linked(date); var t = this;
      $('#dak_event_endDate_jquery_control').datepicker('option', {mindate: $(t).datepicker('getDate')});
wfd_dak_event_endDate_update_linked(date); }";

    $this->widgetSchema['startDate'] = new dakWidgetFormJqueryDate(
      array(
        'date_widget' => $this->widgetSchema['startDate'],
        'culture' => $this->getOption('currentUser')->getCulture(),
	'onSelect' => $startDateJs,
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
      )
    );


    $minutes = array();
    for ($i = 0; $i < 60; $i = $i + 5) $minutes[$i] = sprintf("%02d", $i);

    // Set default start and end date to the next day
    $this->setDefault('startDate', date('Y-m-d', time() + 86400));
    $this->setDefault('startTime', '19:00');
    $this->widgetSchema['startTime']->setOption('minutes', $minutes);
    $this->setDefault('endDate', date('Y-m-d', time() + 86400));
    $this->setDefault('endTime', '21:00');
    $this->widgetSchema['endTime']->setOption('minutes', $minutes);

    $this->setValidator('linkout', new sfValidatorUrl(array('required' => false)));

    $this->setWidget('location_id', new sfWidgetFormDoctrineChoiceNestedSet(array(
      'model'     => 'dakLocation',
      'add_empty' => true,
    )));

    $this->widgetSchema['festival_id']->setOption('query',
      // Limit the number of festivals returned to the ones that ended yesterday or further into the future
      Doctrine_Core::getTable('dakFestival')->createQuery('f')->select('f.*')->where('f.endDate >= ?', date('Y-m-d', time() - 86400))
    );

    if ($this->getOption('festival_id', false)) {
      $this->widgetSchema['festival_id']->setOption('default', $this->getOption('festival_id'));
    }

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
    $editor->config['toolbar'] = dakEventsCommon::CKEditorToolbarCommon();
    $editor->config['entities'] = false;

    $this->widgetSchema['categories_list']->setOption('expanded', true);
    $this->validatorSchema['categories_list']->setOption('required', true);

    $pictureChoices = array();

    if (!$this->isNew()) {
      $pictureChoicesTemp = $this->getObject()->getPictures();

      if (count($pictureChoicesTemp) > 0) {
        foreach ($pictureChoicesTemp as $p) {
          $pictureChoices[$p['id']] = $p;
        }
      }
    }

    $this->widgetSchema['pictures_list'] = new sfWidgetFormChoiceAutocomplete(
      array(
        'choices' => $pictureChoices,
        'class' => 'dakPictureAutocomplete',
        'source' => '@dak_picture_admin_jsonsearch',
        'selectTemplate' => dakPictureChoiceAutocomplete::jQueryUISelectTemplate(),
        'resultTemplate' => dakPictureChoiceAutocomplete::jQueryUIResultTemplate(),
        'focusField' => 'description',
        'list_options' => array(
          'renderer_class' => 'dakPictureChoiceAutocomplete',
         ),
      ),
      array()
    );

    $primaryPicChoice = array();
    if (!$this->isNew() && $this->getObject()->relatedExists('primaryPicture')) {
      $primaryPicChoiceTemp = $this->getObject()->getPrimaryPicture();
      $primaryPicChoice[$primaryPicChoiceTemp->getPrimaryKey()] = $primaryPicChoiceTemp;
    }

    $this->widgetSchema['primaryPicture_id'] = new sfWidgetFormChoiceAutocomplete(
      array(
        'choices' => $primaryPicChoice,
        'multiple' => false,
        'class' => 'dakPictureAutocomplete',
        'source' => '@dak_picture_admin_jsonsearch',
        'selectTemplate' => dakPictureChoiceAutocomplete::jQueryUISelectTemplate(),
        'resultTemplate' => dakPictureChoiceAutocomplete::jQueryUIResultTemplate(),
        'focusField' => 'description',
        'list_options' => array(
          'renderer_class' => 'dakPictureChoiceAutocomplete',
         ),
      ),
      array()
    );

    if ( ! $this->getOption('currentUser')->hasGroup('admin') ) {
      // Widget arranger_is of type sfWidgetFormDoctrineChoice, which supports queries.
      // If the user is not an admin, we make sure to only use
      // the arrangers the user is limited to.
      $user = $this->getOption('currentUser')->getGuardUser();

      $arrangerIds = $this->getOption('currentUser')->getArrangerIds();

      if (count($arrangerIds) == 1) {
        $this->widgetSchema['arranger_id'] = new sfWidgetFormInputHidden();
        $this->setDefault('arranger_id', $arrangerIds[0]);
      } else {
        $this->widgetSchema['arranger_id']->setOption('query', 
          Doctrine_Core::getTable('dakArranger')->createQuery('a')->select('a.*')->leftJoin('a.users u')->where('u.user_id = ?', $user->getId())
        );
      }

      $this->validatorSchema['arranger_id']->setOption('query', 
        Doctrine_Core::getTable('dakArranger')->createQuery('a')->select('a.*')->leftJoin('a.users u')->where('u.user_id = ?', $user->getId())
      );

      // Mere arrangers won't be able to accept event at a location if
      // the location demands accept from location owner (if it's defined as so).
      unset($this['is_accepted']);
    }
  }

  public function checkIfLocationIsSet ($validator, $values) {
    if (empty($values['customLocation']) && (empty($values['location_id']) || ($values['location_id'] == 0))) {
      $errorMsg = "You must specify either a custom location or a recurring location";

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
