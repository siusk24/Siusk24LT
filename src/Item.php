<?php

namespace ParcelStars;

use ParcelStars\Exception\ParcelStarsException;

/**
 *
 */
class Item
{
    private $description;
    private $item_price;
    private $item_amount;

    public function __construct()
    {

    }

    public function setDescription($description)
    {
        $this->description = $description;

        return $this;
    }

    public function setItemPrice($item_price)
    {
        $this->item_price = $item_price;

        return $this;
    }

    public function setItemAmount($item_amount)
    {
        $this->item_amount = $item_amount;

        return $this;
    }

    public function generateItem()
    {
        if (!$this->description) throw new ParcelStarsException('All the fields must be filled. description is missing.');
        if (!$this->item_price) throw new ParcelStarsException('All the fields must be filled. item_price is missing.');
        if (!$this->item_amount) throw new ParcelStarsException('All the fields must be filled. item_amount is missing.');
        return array(
            'description' => $this->description,
            'item_price' => $this->item_price,
            'item_amount' => $this->item_amount
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
