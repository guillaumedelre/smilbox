<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 12/11/16
 * Time: 19:34
 */

namespace AppBundle\Model\Effect;

use AppBundle\Model\OptionValueInterface;

class ColorPoint implements OptionValueInterface
{
    const CMD = 'colorpoint %d';

    const GREEN = 0;
    const RED_YELLOW = 1;
    const BLUE = 2;
    const PURPLE = 3;

    /**
     * @var int
     * @Assert\Choice({0,1,2,3})
     */
    protected $quadrant;

    /**
     * @return int
     */
    public function getQuadrant()
    {
        return $this->quadrant;
    }

    /**
     * @param int $quadrant
     * @return ColorPoint
     */
    public function setQuadrant($quadrant)
    {
        $this->quadrant = $quadrant;
        return $this;
    }

    public function getOptionValue()
    {
        // TODO: validate before return

        return sprintf(
            self::CMD,
            $this->getQuadrant()
        );
    }

}