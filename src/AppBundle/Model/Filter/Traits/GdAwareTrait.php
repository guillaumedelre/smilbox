<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 20/11/16
 * Time: 20:37
 */

namespace AppBundle\Model\Filter\Traits;

trait GdAwareTrait
{
    /**
     * @return bool
     */
    public static function isAware()
    {
        return function_exists("gd_info");
    }
}