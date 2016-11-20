<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 20/11/16
 * Time: 20:42
 */

namespace AppBundle\Model\Filter;

interface FilterAwareInterface
{
    /**
     * @return bool
     */
    public static function isAware();
}