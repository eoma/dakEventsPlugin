<?php

/**
 * eventTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class PlugindakEventTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object eventTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('dakEvent');
    }

    public function defaultJoins(Doctrine_Query $q)
    {
        $rootAlias = $q->getRootAlias();

        $q->leftJoin($rootAlias . '.commonLocation l')
          ->leftJoin($rootAlias . '.arranger a')
          ->leftJoin($rootAlias . '.categories c')
          ->leftJoin($rootAlias . '.primaryPicture pp')
          ->leftJoin($rootAlias . '.pictures p')
          ->leftJoin($rootAlias . '.festival f');

        return $q;
    }

    public function defaultSelect(Doctrine_Query $q) {
        //This function assumes you've used eventTable::defaultJoins

        $rootAlias = $q->getRootAlias();

        $q->select( $rootAlias . '.*, l.name, a.name, c.name, '
                    . ' f.title, f.startDate, f.startTime, '
                    . 'pp.filename, pp.description, pp.width, pp.height, pp.mime_type, '
                    . 'p.filename, p.description, p.width, p.height, p.mime_type');

        return $q;
    }
    
    public function defaultSummarySelect(Doctrine_Query $q) {
        //This function assumes you've used eventTable::defaultJoins

        $q->select( 'title, leadParagraph, startDate, startTime, '
                    . 'endDate, endTime, is_accepted, is_public, '
                    . 'customLocation, location_id, arranger_id, '
                    . 'festival_id, primaryPicture_id, covercharge, '
                    . 'updated_at, created_at, '
                    . 'l.name, a.name, c.name, '
                    . 'f.title, f.startDate, f.startTime, '
                    . 'pp.filename, pp.description, pp.width, pp.height, pp.mime_type');

        return $q;
    }

    public function defaultOrderBy(Doctrine_Query $q, $order = 'asc')
    {
        $rootAlias = $q->getRootAlias();

        if ( !in_array($order, array('asc', 'desc')) ) {
            $order = 'asc';
        }

        $q->orderBy($rootAlias . '.startDate ' . $order . ', ' .
                    $rootAlias . '.startTime ' . $order . ', ' .
                    $rootAlias . '.title ' . $order);

        return $q;
    }

    public function defaultRequirements (Doctrine_Query $q) {
        $rootAlias = $q->getRootAlias();

        $q->where($rootAlias . '.startDate >= ? OR ' . $rootAlias . '.endDate >= ?', 
                  array(date('Y-m-d'), date('Y-m-d')));

        return $q;
    }

    public function defaultJoinsAndRequirements (Doctrine_Query $q) {
        $q = $this->defaultJoins($q);
        $q = $this->defaultRequirements($q);

        return $q;
    }

    public function defaultQueryOptions(Doctrine_Query $q, $order = 'asc')
    {
        $q = $this->defaultJoins($q);
        $q = $this->defaultSelect($q);
        $q = $this->defaultOrderBy($q, $order);

        return $q;
    }

    public function defaultQueryOptionsAndRequirements(Doctrine_Query $q, $order = 'asc')
    {
        $q = $this->defaultQueryOptions($q, $order);
        $q = $this->defaultRequirements($q);

        return $q;
    }

	/**
	 * Will return an initial Doctrine_Query instance configured to return
	 * event frequencies per month. It can be used in further queries, eg. combine
	 * arranger ids, location ids, etc.
	 *
	 * @return object Doctrine_Query
	 */
	public function getNumberOfEventsPerMonth () {
		$driver = strtolower(Doctrine_Manager::connection()->getDriverName());

		$q = $this->createQuery('e');
		$q->select('COUNT(e.id) as num');

		if ($driver == 'sqlite') {
			$q->addSelect("strftime('%Y-%m-01', e.startdate) as date");
		} else {
			$q->addSelect("DATE_FORMAT(e.startdate, '%Y-%m-01') as date");
		}

		$q->groupBy('date');
		$q->orderBy('date asc');

		return $q;
	}
}
