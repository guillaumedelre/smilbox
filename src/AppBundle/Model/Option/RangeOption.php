<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 12/11/16
 * Time: 18:40
 */

namespace AppBundle\Model\Option;

class RangeOption extends AbstractOption
{
    /**
     * @var int
     */
    protected $min = 0;

    /**
     * @var int
     */
    protected $max = 0;

    /**
     * @return int
     */
    public function getMin()
    {
        return $this->min;
    }

    /**
     * @param int $min
     * @return RangeOption
     */
    public function setMin($min)
    {
        $this->min = $min;
        return $this;
    }

    /**
     * @return int
     */
    public function getMax()
    {
        return $this->max;
    }

    /**
     * @param int $max
     * @return RangeOption
     */
    public function setMax($max)
    {
        $this->max = $max;
        return $this;
    }

    public function getForm()
    {
        $return = sprintf(
            '<form><input id="range-%s" type="range" value="%d" min="%d" max="%d"></form>',
            $this->getName(),
            $this->getDefault(),
            $this->getMin(),
            $this->getMax()
        );

        return $return;
    }
}