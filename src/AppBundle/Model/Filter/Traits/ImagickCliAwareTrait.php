<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 20/11/16
 * Time: 20:37
 */

namespace AppBundle\Model\Filter\Traits;

trait ImagickCliAwareTrait
{
    /**
     * @return bool
     */
    public function isAware()
    {
        return true;
    }
}