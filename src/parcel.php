<?php

namespace ParcelStars;

/**
 *
 */
class Parcel
{
    private $amount;
    private $unit_weight;
    private $width;
    private $length;
    private $height;

    public function __construct($amount, $unit_weight, $width, $length, $heigth)
    {
        $this->amount = $amount;
        $this->unit_weight = $unit_weight;
        $this->width = $width;
        $this->length = $length;
        $this->heigth = $heigth;
    }

    private function generateParcel()
    {
        $parcel = array(
        'amount' => $this->amount,
        'unit_weight' => $this->unit_weight,
        'width' => $this->width,
        'length' => $this->length,
        'heigth' => $this->heigth
      );

        return $parcel;
    }

    public function return_object()
    {
        return $this->generateParcel();
    }

    public function return_json()
    {
        return json_encode($this->generateParcel());
    }

    public function __toArray()
    {
        return $this->generateParcel();
    }
}
