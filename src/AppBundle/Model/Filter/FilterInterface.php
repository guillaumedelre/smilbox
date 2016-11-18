<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 18/11/16
 * Time: 22:08
 */

namespace AppBundle\Model\Filter;


interface FilterInterface
{
    /**
     * @param string $filename
     */
    public static function apply($filename);
}