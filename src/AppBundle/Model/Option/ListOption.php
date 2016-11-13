<?php
/**
 * Created by PhpStorm.
 * User: gdelre
 * Date: 12/11/16
 * Time: 18:40
 */

namespace AppBundle\Model\Option;

use Doctrine\Common\Inflector\Inflector;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;

class ListOption extends AbstractOption
{
    /**
     * @var ParameterBag
     */
    protected $collection;

    /**
     * @return ParameterBag
     */
    public function getCollection()
    {
        return $this->collection;
    }

    /**
     * @param ParameterBag $collection
     * @return ListOption
     */
    public function setCollection($collection)
    {
        $this->collection = $collection;
        return $this;
    }

    /**
     * @param $optName
     * @param $data
     * @return ListOption
     */
    public static function hydrate($optName, $data)
    {
        $option = new self();
        $option->setLabel($data['label']);
        $option->setName($optName);

        foreach ($data as $key => $value) {
            if ($key == 'collection') {
                $collection = new ParameterBag();
                $collection->set($optName, $value);
                $option->{'set' . ucfirst(Inflector::camelize($key))}($collection);
            } else {
                $option->{'set' . ucfirst(Inflector::camelize($key))}($value);
            }
        }

        return $option;
    }

    /**
     * @return string
     */
    public function getForm()
    {
        $items = '';
        $itemPattern = '<option value="%s" %s>%s</option>';
        foreach ($this->getCollection()->get($this->getName()) as $item) {
            $items .= sprintf($itemPattern, $item, $this->getDefault() == $item ? 'selected="selected"' : '', ucfirst($item));
        }

        $selectPattern = '<select>%s</select>';
        $return = sprintf(
            $selectPattern,
            $items
        );

        return $return;
    }
}