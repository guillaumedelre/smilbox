<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 13/11/16
 * Time: 13:50
 */

namespace AppBundle\Model;

use AppBundle\Model\Option\RangeOption;
use Doctrine\Common\Util\Inflector;

class Widget
{
    /**
     * @var RangeOption
     */
    private $option;

    /**
     * @return RangeOption
     */
    public function getOption()
    {
        return $this->option;
    }

    /**
     * @param string $name
     * @param array $data
     */
    public function loadFromData($name, array $data = [])
    {
        switch ($data['model']) {
            case 'range':
                /** @var RangeOption option */
                $this->option = (new RangeOption())->setName($name);
                foreach ($data as $key => $value) {
                    $this->option->{'set' . ucfirst(Inflector::camelize($key))}($value);
                }
                break;
        }
    }

    public function getForm()
    {
        return $this->option->getForm();
    }
}