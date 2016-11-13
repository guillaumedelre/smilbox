<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 13/11/16
 * Time: 13:50
 */

namespace AppBundle\Model;

use AppBundle\Model\Option\AbstractOption;
use AppBundle\Model\Option\ListOption;
use AppBundle\Model\Option\RangeOption;

class Widget
{
    /**
     * @var bool
     */
    private $compound = false;

    /**
     * @var string
     */
    private $label;

    /**
     * @var RangeOption[]
     */
    private $options;

    /**
     * @return RangeOption[]
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * @return string
     */
    public function getLabel()
    {
        return ucfirst($this->label);
    }

    /**
     * @param string $label
     * @return Widget
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isCompound()
    {
        return $this->compound;
    }

    /**
     * @param string $name
     * @param array $data
     */
    public function loadFromData($name, array $data = [])
    {
        if (is_int(key($data))) {
            $this->compound = true;
        }

        if ($this->isCompound()) {
            foreach ($data as $key => $widget) {
                $this->buildOption($name, $widget);
            }
        } else {
            $this->buildOption($name, $data);
        }
    }

    /**
     * @param $name
     * @param array $data
     */
    private function buildOption($name, array $data)
    {
        if (!isset($data['model'])) {
            throw new \LogicException('Missing model');
        }

        switch ($data['model']) {
            case 'range':
                $optName = $name . (isset($data['composite']) ? '-' . $data['composite'] : '');
                $option = RangeOption::hydrate($optName, $data);

                if ($this->isCompound()) {
                    $this->options[$name][$data['composite']] = $option;
                } else {
                    $this->options[$name] = $option;
                }
                break;
            case 'list':
                $optName = $name;
                $option = ListOption::hydrate($optName, $data);

                if ($this->isCompound()) {
                    $this->options[$name][$data['composite']] = $option;
                } else {
                    $this->options[$name] = $option;
                }
                break;
        }

        $this->setLabel($option->getLabel());
    }

    /**
     * @return string
     */
    public function getForm()
    {
        $form = '<form method="post">%s</form>';

        $return = '';
        if ($this->isCompound()) {
            foreach ($this->getOptions() as $composites) {
                /** @var AbstractOption|RangeOption $composite */
                foreach ($composites as $composite) {
                    $return .= $composite->getForm();
                }
            }
        } else {
            foreach ($this->getOptions() as $option) {
                $return .= $option->getForm();
            }
        }

        return sprintf($form, $return);
    }
}