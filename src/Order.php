<?php

namespace ParcelStars;

use ParcelStars\Sender;
use ParcelStars\Receiver;
use ParcelStars\Item;
use ParcelStars\Parcel;

class Order
{
    private $department_shortname;
    private $service_code;
    private $sender;
    private $receiver;
    private $parcel_type;
    private $parcels = array();
    private $items = array();
    private $reference;
    private $cod_amount;
    private $callback_urls;


    public function __construct($department_shortname, $service_code, Sender $sender, Receiver $receiver, $parcel_type, $parcels, $reference, $cod_amount, $items, $callback_urls = array())
    {
        $this->addParcels($parcels);
        $this->addItems($items);

        $this->setDepartmentShortname($department_shortname);
        $this->setServiceCode($service_code);
        $this->setSender($sender);
        $this->setReceiver($receiver);
        $this->setParcelType($parcel_type);
        $this->setReference($reference);
        $this->setCodAmount($cod_amount);
        $this->setCallbackUrls($callback_urls);
    }

    public function addParcels($parcels)
    {
        if (is_object($parcels)) {
            array_push($this->parcels, $parcels->returnObject());
            return $this;
        } else {
            array_merge($this->parcels, $parcels);
        }

        return $this;
    }

    public function addItems($items)
    {
        if (is_object($items)) {
            array_push($this->items, $items->returnObject());
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

    public function setSender(Sender $sender)
    {
        $this->sender = $sender;

        return $this;
    }

    public function setReceiver(Receiver $receiver)
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
          'sender' => $this->sender->returnObject(),
          'receiver' => $this->receiver->returnObject(),
          'parcel_type' => $this->parcel_type,
          'parcels' => $this->parcels,
          'reference' => $this->reference,
          'cod_amount' => $this->cod_amount,
          'items' => $this->items,
          'callback_urls' => $this->callback_urls
      );

        return $order;
    }

    public function returnObject()
    {
        return $this->generateOrder();
    }

    public function returnJson()
    {
        return json_encode($this->generateOrder());
    }

    public function __toArray()
    {
        return $this->generateOrder();
    }
}
