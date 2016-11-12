<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 12/11/16
 * Time: 18:40
 */

namespace AppBundle\Model;

use Symfony\Component\Validator\Constraints as Assert;

class RangeOption
{
    /**
     * @var string
     * @Assert\NotBlank()
     */
    protected $name;

    /**
     * @var int
     * @Assert/Type(
     *      type="integer",
     *      message="The value {{ value }} is not a valid {{ type }}."
     * )
     * @Assert/Range(
     *      min = -100,
     *      max = 100,
     *      minMessage = "The value must be minimum {{ limit }}",
     *      maxMessage = "The value must be maximum {{ limit }}"
     * )
     */
    protected $value = 0;

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param mixed $name
     * @return RangeOption
     */
    public function setName($name)
    {
        $this->name = $name;
        return $this;
    }

    /**
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    /**
     * @param int $value
     * @return RangeOption
     */
    public function setValue($value)
    {
        $this->value = $value;
        return $this;
    }
}