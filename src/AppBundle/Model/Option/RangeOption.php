<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 12/11/16
 * Time: 18:40
 */

namespace AppBundle\Model\Option;

use Doctrine\Common\Util\Inflector;
use Symfony\Component\ExpressionLanguage\ExpressionLanguage;

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
     * @var int
     */
    protected $step;

    /**
     * @var string
     */
    protected $compute;

    /**
     * @return string
     */
    public function getCompute()
    {
        return $this->compute;
    }

    /**
     * @param string $compute
     * @return RangeOption
     */
    public function setCompute($compute)
    {
        $this->compute = $compute;
        return $this;
    }

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

    /**
     * @return int
     */
    public function getStep()
    {
        return $this->step;
    }

    /**
     * @param int $step
     * @return RangeOption
     */
    public function setStep($step)
    {
        $this->step = $step;
        return $this;
    }

    /**
     * @param $optName
     * @param $data
     * @return RangeOption
     */
    public static function hydrate($optName, $data)
    {
        $option = new self();
        $option->setLabel($data['label']);
        $option->setName($optName);

        unset($data['composite']);
        foreach ($data as $key => $value) {
            $option->{'set' . ucfirst(Inflector::camelize($key))}($value);
        }

        return $option;
    }

    /**
     * @return string
     */
    public function getForm()
    {
        $pattern = '
        <ul class="range-list">
            <li>%d</li>
            <li data-range="range-%s" class="range-current-value">%d</li>
            <li>%d</li>
        </ul>
        <input id="range-%s" name="%s" type="range" value="%d" min="%d" max="%d" step="%d">
        <input name="compute" type="hidden" value="' . $this->getCompute() . '">
        ';

        $language = new ExpressionLanguage();
        $return = sprintf(
            $pattern,
            $language->evaluate($this->getMin() . str_replace('*', '/', $this->getCompute())),
            $this->getName(),
            $language->evaluate($this->getDefault() . str_replace('*', '/', $this->getCompute())),
            $language->evaluate($this->getMax() . str_replace('*', '/', $this->getCompute())),
            $this->getName(),
            $this->getName(),
            $language->evaluate($this->getDefault() . str_replace('*', '/', $this->getCompute())),
            $language->evaluate($this->getMin() . str_replace('*', '/', $this->getCompute())),
            $language->evaluate($this->getMax() . str_replace('*', '/', $this->getCompute())),
            $this->getStep()
        );

        return $return;
    }
}