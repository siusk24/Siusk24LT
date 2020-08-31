<?php

namespace Siusk24LT;

use Siusk24LT\Exception\Siusk24LTException;

/**
 *
 */
class Item
{
    private $description;
    private $value;
    private $units;

    public function __construct()
    {

    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function setItemPrice($value)
    {
        $this->value = $value;

        return $this;
    }

    public function setItemAmount($units)
    {
        $this->units = $units;

        return $this;
    }

    public function generateItem()
    {
        if (!$this->description) throw new Siusk24LTException('All the fields must be filled. description is missing.');
        if (!$this->value) throw new Siusk24LTException('All the fields must be filled. value is missing.');
        if (!$this->units) throw new Siusk24LTException('All the fields must be filled. units is missing.');
        return array(
            'description' => $this->description,
            'value' => $this->value,
            'units' => $this->units
        );
    }

    public function returnObject()
    {
        return $this->generateItem();
    }

    public function returnJson()
    {
        return json_encode($this->generateItem());
    }

    public function __toArray()
    {
        return $this->generateItem();
    }
}
