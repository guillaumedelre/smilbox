<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 12/11/16
 * Time: 19:41
 */

namespace AppBundle\Model\Effect;

use AppBundle\Model\OptionValueInterface;
use Symfony\Component\Validator\Constraints as Assert;

class Solarize implements OptionValueInterface
{
    const CMD = 'solarize %d,%d,%d,%d,%d';

    private $yuv = true;

    /**
     * @var int
     * @Assert\Range(
     *      min = 0,
     *      max = 255,
     *      minMessage = "You must be greater than {{ limit }}",
     *      maxMessage = "You must be lower than {{ limit }}"
     * )
     */
    private $x0 = 128;

    /**
     * @var int
     * @Assert\Range(
     *      min = 0,
     *      max = 255,
     *      minMessage = "You must be greater than {{ limit }}",
     *      maxMessage = "You must be lower than {{ limit }}"
     * )
     */
    private $y1;

    /**
     * @var int
     * @Assert\Range(
     *      min = 0,
     *      max = 255,
     *      minMessage = "You must be greater than {{ limit }}",
     *      maxMessage = "You must be lower than {{ limit }}"
     * )
     */
    private $y2;

    /**
     * @var int
     * @Assert\Range(
     *      min = 0,
     *      max = 255,
     *      minMessage = "You must be greater than {{ limit }}",
     *      maxMessage = "You must be lower than {{ limit }}"
     * )
     */
    private $y3;

    /**
     * @return boolean
     */
    public function isYuv()
    {
        return $this->yuv;
    }

    /**
     * @param boolean $yuv
     * @return Solarize
     */
    public function setYuv($yuv)
    {
        $this->yuv = $yuv;
        return $this;
    }

    /**
     * @return int
     */
    public function getX0()
    {
        return $this->x0;
    }

    /**
     * @param int $x0
     * @return Solarize
     */
    public function setX0($x0)
    {
        $this->x0 = $x0;
        return $this;
    }

    /**
     * @return int
     */
    public function getY1()
    {
        return $this->y1;
    }

    /**
     * @param int $y1
     * @return Solarize
     */
    public function setY1($y1)
    {
        $this->y1 = $y1;
        return $this;
    }

    /**
     * @return int
     */
    public function getY2()
    {
        return $this->y2;
    }

    /**
     * @param int $y2
     * @return Solarize
     */
    public function setY2($y2)
    {
        $this->y2 = $y2;
        return $this;
    }

    /**
     * @return int
     */
    public function getY3()
    {
        return $this->y3;
    }

    /**
     * @param int $y3
     * @return Solarize
     */
    public function setY3($y3)
    {
        $this->y3 = $y3;
        return $this;
    }

    public function getOptionValue()
    {
        // TODO: validate before return

        return sprintf(
            self::CMD,
            $this->isYuv() ? 1 : 0,
            $this->getX0(),
            $this->getY1(),
            $this->getY2(),
            $this->getY3()
        );
    }
}