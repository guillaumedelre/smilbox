<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 13/11/16
 * Time: 13:44
 */

namespace AppBundle\Model\Option;

abstract class AbstractOption
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var string
     */
    protected $label;

    /**
     * @var string
     */
    protected $command;

    /**
     * @var string
     */
    protected $model;

    /**
     * @var string
     */
    protected $default;

    /**
     * @return string
     */
    public function getDefault()
    {
        return $this->default;
    }

    /**
     * @param string $default
     * @return static
     */
    public function setDefault($default)
    {
        $this->default = $default;
        return $this;
    }

    /**
     * @return string
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @param string $model
     * @return static
     */
    public function setModel($model)
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return string
     */
    public function getCommand()
    {
        return $this->command;
    }

    /**
     * @param string $command
     * @return static
     */
    public function setCommand($command)
    {
        $this->command = $command;
        return $this;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return static
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
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
     * @return static
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }

    abstract public function getForm();
}