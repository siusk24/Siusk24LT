<?php

namespace ParcelStars;

/**
 *
 */
class Item
{
    private $description;
    private $item_price;
    private $item_amount;

    public function __construct($description, $item_price, $item_amount)
    {
        $this->description = $description;
        $this->item_price = $item_price;
        $this->item_amount = $item_amount;
    }

    private function generateItem()
    {
        $item = array(
          'description' => $this->description,
          'item_price' => $this->item_price,
          'item_amount' => $this->item_amount
        );

        return $item;
    }

    public function return_object()
    {
        return $this->generateItem();
    }

    public function return_json()
    {
        return json_encode($this->generateItem());
    }

    public function __toArray()
    {
        return $this->generateItem();
    }
}
