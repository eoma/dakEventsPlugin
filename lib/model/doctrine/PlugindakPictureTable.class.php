<?php

/**
 * requirementCateringTable
 * 
 * This class has been auto-generated by the Doctrine ORM Framework
 */
abstract class PlugindakPictureTable extends PlugindakFileTable
{
    /**
     * Returns an instance of this class.
     *
     * @return object requirementCateringTable
     */
    public static function getInstance()
    {
        return Doctrine_Core::getTable('dakPicture');
    }
}
