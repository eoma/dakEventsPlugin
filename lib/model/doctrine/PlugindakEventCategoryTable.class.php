<?php

/**
 * eventCategoryTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class PlugindakEventCategoryTable extends Doctrine_Table
{
    /**
     * Returns an instance of this class.
     *
     * @return object eventCategoryTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('dakEventCategory');
    }
}
