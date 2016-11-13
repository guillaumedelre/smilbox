<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 13/11/16
 * Time: 13:50
 */

namespace AppBundle\Model;

interface WidgetInterface
{
    /**
     * @return string $option
     * @return Widget
     */
    public function getWidget($option);
}