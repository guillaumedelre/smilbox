<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 12/11/16
 * Time: 18:40
 */

namespace AppBundle\Model;

use Symfony\Component\HttpFoundation\ParameterBag;
use Symfony\Component\Validator\Constraints as Assert;

class ChoiceOption
{
    /**
     * @var ParameterBag
     */
    protected $choices;

    /**
     * ChoiceOption constructor.
     * @param array $options
     */
    public function __construct(array $options = [])
    {
        $this->choices = $choices;
    }


}