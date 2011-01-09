<?php

/**
 * event filter form.
 *
 * @package    kvarteret_events
 * @subpackage filter
 * @author     Endre Oma
 * @version    SVN: $Id: sfDoctrineFormFilterTemplate.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class PlugindakEventFormFilter extends BasedakEventFormFilter
{
  public function configure()
  {
    if (!($this->getOption('currentUser')) instanceof sfGuardSecurityUser) {
      throw new InvalidArgumentException("You must pass a user object as an option to this form!");
    }

    $arrangerQuery = Doctrine_Core::getTable('arranger')
      ->createQuery('a')
      ->select('a.*');
    Doctrine_Core::getTable('arranger')->defaultOrderBy($arrangerQuery);

    $festivalQuery = Doctrine_Core::getTable('festival')
      ->createQuery('f')
      ->select('f.*')
      ->where('f.startDate >= ? OR f.endDate >= ?', array(date('Y-m-d'), date('Y-m-d')));
    Doctrine_Core::getTable('festival')->defaultOrderBy($festivalQuery);

    if ( ! $this->getOption('currentUser')->hasGroup('admin') ) {
      // Widget arranger_is of type sfWidgetFormDoctrineChoice, which supports queries.
      // If the user is not an admin, we make sure to only use
      // the arrangers the user is limited to.
      $user = $this->getOption('currentUser');

      $arrangerQuery->whereIn('a.id', $user->getArrangerIds());

      $festivalQuery->leftJoin('f.arrangers a')
        ->whereIn('a.id', $user->getArrangerIds());

    }

    $this->widgetSchema['arranger_id']->setOption('query', $arrangerQuery);
    $this->widgetSchema['festival_id']->setOption('query', $festivalQuery);

  }
}
