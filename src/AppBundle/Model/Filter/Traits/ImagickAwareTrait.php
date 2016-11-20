<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 20/11/16
 * Time: 20:37
 */

namespace AppBundle\Model\Filter\Traits;

trait ImagickAwareTrait
{
    /**
     * @return bool
     */
    public static function isAware()
    {
        try {
            return (bool)\Imagick::getVersion();
        } catch (\Exception $e) {
            return false;
        }
    }
}