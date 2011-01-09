<?php

/**
 * location form.
 *
 * @package    kvarteret_events
 * @subpackage form
 * @author     Endre Oma
 * @version    SVN: $Id: sfDoctrineFormTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PlugindakLocationForm extends BasedakLocationForm
{
  public function setup()
  {
    parent::setup();

    unset(
      $this['created_at'], $this['updated_at']
    );

    // Following sections are taken from http://halestock.wordpress.com/2010/02/03/symfony-implementing-a-nested-set-part-one/

    // create a new widget to represent this location's "parent"
    $this->setWidget('parent', new sfWidgetFormDoctrineChoiceNestedSet(array(
      'model'     => 'dakLocation',
      'add_empty' => true,
    )));

    // if the current location has a parent, make it the default choice
    if ($this->getObject()->getNode()->hasParent())
    {
      $this->setDefault('parent', $this->getObject()->getNode()->getParent()->getId());
    }

    // only allow the user to change the name and description of the location, and its parent
    $this->useFields(array(
      'name',
      'description',
      'parent',
    ));

    // set labels of fields
    $this->widgetSchema->setLabels(array(
      'name'   => 'Location name',
      'description' => 'Location description',
      'parent' => 'Parent location',
    ));

    // set a validator for parent which prevents a location being moved to one of its own descendants
    $this->setValidator('parent', new sfValidatorDoctrineChoiceNestedSet(array(
      'required' => false,
      'model'    => 'dakLocation',
      'node'     => $this->getObject(),
    )));
    $this->getValidator('parent')->setMessage('node', 'A location cannot be made a descendent of itself.');

  }

  /**
   * Updates and saves the current object. Overrides the parent method
   * by treating the record as a node in the nested set and updating
   * the tree accordingly.
   *
   * @param Doctrine_Connection $con An optional connection parameter
   */
  public function doSave($con = null)
  {
    // save the record itself
    parent::doSave($con);
    // if a parent has been specified, add/move this node to be the child of that node
    if ($this->getValue('parent'))
    {
      $parent = Doctrine::getTable('dakLocation')->findOneById($this->getValue('parent'));
      if ($this->isNew())
      {
        $this->getObject()->getNode()->insertAsLastChildOf($parent);
      }
      else
      {
        $this->getObject()->getNode()->moveAsLastChildOf($parent);
      }
    }
    // if no parent was selected, add/move this node to be a new root in the tree
    else
    {
      $categoryTree = Doctrine::getTable('dakLocation')->getTree();
      if ($this->isNew())
      {
        $categoryTree->createRoot($this->getObject());
      }
      else
      {
        $this->getObject()->getNode()->makeRoot($this->getObject()->getId());
      }
    }
  }

}
