<?php

/**
 * arranger form.
 *
 * @package    kvarteret_events
 * @subpackage form
 * @author     Endre Oma
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PlugindakArrangerForm extends BasedakArrangerForm
{

  protected $scheduledForDeletion = array();

  public function setup()
  {
    parent::setup();

    if (!($this->getOption('currentUser')) instanceof sfGuardSecurityUser) {
      throw new InvalidArgumentException("You must pass a user object as an option to this form!");
    }

    unset(
      $this['created_at'], $this['updated_at'], $this['festivals_list']
    );

    $logoChoice = array();
    if (!$this->isNew() && $this->getObject()->relatedExists('logo')) {
      $logoTemp = $this->getObject()->getLogo();
      $logoChoice[$logoTemp->getPrimaryKey()] = $logoTemp;
    }

    $this->widgetSchema['picture_id'] = new sfWidgetFormChoiceAutocomplete(
      array(
        'choices' => $logoChoice,
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

    if ($this->getOption('currentUser')->hasGroup('admin')) {
      if ( ! $this->isNew() ) {
        // Don't embed non-existing relations
        $this->embedRelation('users', 'dakArrangerUserForm', array( 'options' => array('hideArranger' => true)));
      }

      $arrangerUserForm = new dakArrangerUserForm(array(), array('hideArranger' => true));
      $arrangerUserForm->getWidget('user_id')->setOption('add_empty', true );

      $this->embedForm('newArrangerUser', $arrangerUserForm);

    }
  }

  // Taken from http://prendreuncafe.com/blog/post/2009/11/29/Embedding-Relations-in-Forms-with-Symfony-1.3-and-Doctrine
  protected function doBind( array $values )
  {

    if ( $this->isValid() && ('' === trim($values['newArrangerUser']['user_id'])) )
    {
      unset($values['newArrangerUser'], $this['newArrangerUser']);
    }

    if (isset($values['newArrangerUser']) && ('' !== trim($values['newArrangerUser']['user_id']))) {
      // We need to reassign the arranger_id, since we removed it
      // and it's an required part of the form.
      $values['newArrangerUser']['arranger_id'] = $this->getObject()->getId();
    }
    
    if (isset($values['users']))
    {
      foreach ($values['users'] as $i => &$arrangerUser)
      {
        // We need to reassign the arranger_id, since we removed it
        // and it's an required part of the form.
        $arrangerUser['arranger_id'] = $this->getObject()->getId();

        if (isset($arrangerUser['delete']) && $arrangerUser['id'])
        {
	  // Schedule objects for deletion
          $this->scheduledForDeletion[$i] = $arrangerUser['id'];
        }
      }
    }
    
    parent::doBind($values);
  }

  /**
   * Updates object with provided values, dealing with evantual relation deletion
   *
   * @see sfFormDoctrine::doUpdateObject()
   */
  protected function doUpdateObject($values)
  {
    if (count($this->scheduledForDeletion))
    {
      foreach ($this->scheduledForDeletion as $index => $id)
      {
        // We'll delete objects marked for deletion
        unset($values['users'][$index]);
        unset($this->object['users'][$index]);
        Doctrine::getTable('dakArrangerUser')->findOneById($id)->delete();
      }
    }
 
    return parent::doUpdateObject( $values );
  }

  /**
   * Saves embedded form objects.
   *
   * @param mixed $con   An optional connection object
   * @param array $forms An array of forms
   */
  public function saveEmbeddedForms($con = null, $forms = null)
  {
    if (null === $con)
    {
      $con = $this->getConnection();
    }
 
    if (null === $forms)
    {
      $forms = $this->embeddedForms;
    }
    
    foreach ($forms as $form)
    {
      if ($form instanceof sfFormObject)
      {
        if (!in_array($form->getObject()->getId(), $this->scheduledForDeletion))
        {
          $form->saveEmbeddedForms($con);
          $form->getObject()->save($con);
        }
      }
      else
      {
        $this->saveEmbeddedForms($con, $form->getEmbeddedForms());
      }
    }
  }

}
