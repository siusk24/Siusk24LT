<?php

namespace ParcelStars;

/**
 *
 */
class Order
{
    private $department_shortname;
    private $service_code;
    private $sender;
    private $receiver;
    private $parcel_type;
    private $parcels;
    private $reference;
    private $cod_amount;
    private $callback_urls;


    public function __construct($department_shortname, $service_code, $sender, $receiver, $parcel_type, $parcels, $reference, $cod_amount, $items, $callback_urls = array())
    {
        if (is_object($parcels)) {
            $parcels = array($parcels->return_object());
        }
        if (is_object($items)) {
            $items = array($items->return_object());
        }
        $this->department_shortname = $department_shortname;
        $this->service_code = $service_code;
        $this->sender = $sender;
        $this->receiver = $receiver;
        $this->parcel_type = $parcel_type;
        $this->parcels = $parcels;
        $this->reference = $reference;
        $this->cod_amount = $cod_amount;
        $this->items = $items;
        $this->callback_urls = $callback_urls;
    }

    public function addParcels($parcels)
    {
        if (is_object($parcels)) {
            array_push($this->parcels, $parcels->return_object());
            return $this;
        } else {
            array_merge($this->parcels, $parcels);
        }

        return $this;
    }

    public function addItems($items)
    {
        if (is_object($items)) {
            array_push($this->items, $items->return_object());
        } else {
            array_merge($this->items, $items);
        }

        return $this;
    }

    public function setDepartmentShortname($department_shortname)
    {
        $this->department_shortname = $department_shortname;

        return $this;
    }

    public function setServiceCode($service_code)
    {
        $this->service_code = $service_code;

        return $this;
    }

    public function setSender($sender)
    {
        $this->sender = $sender;

        return $this;
    }

    public function setReceiver($receiver)
    {
        $this->receiver = $receiver;

        return $this;
    }

    public function setParcelType($parcel_type)
    {
        $this->parcel_type = $parcel_type;

        return $this;
    }

    public function setParcels($parcels)
    {
        $this->parcels = $parcels;

        return $this;
    }

    public function setReference($reference)
    {
        $this->reference = $reference;

        return $this;
    }

    public function setCodAmount($cod_amount)
    {
        $this->cod_amount = $cod_amount;

        return $this;
    }

    public function setItems($items)
    {
        $this->items = $items;

        return $this;
    }

    public function setCallbackUrls($callback_urls)
    {
        $this->callback_urls = $callback_urls;

        return $this;
    }

    private function generateOrder()
    {
        $order = array(
          'department_shortname' => $this->department_shortname,
          'service_code' => $this->service_code,
          'sender' => $this->sender->return_object(),
          'receiver' => $this->receiver->return_object(),
          'parcel_type' => $this->parcel_type,
          'parcels' => $this->parcels,
          'reference' => $this->reference,
          'cod_amount' => $this->cod_amount,
          'items' => $this->items,
          'callback_urls' => $this->callback_urls
      );

        return $order;
    }

    public function return_object()
    {
        return $this->generateOrder();
    }

    public function return_json()
    {
        return json_encode($this->generateOrder());
    }

    public function __toArray()
    {
        return $this->generateOrder();
    }
}
