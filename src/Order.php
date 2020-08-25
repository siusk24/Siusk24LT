<?php

namespace Siusk24LT;

use Siusk24LT\Exception\Siusk24LTException;
use Siusk24LT\Sender;
use Siusk24LT\Receiver;
use Siusk24LT\Item;
use Siusk24LT\Parcel;

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


    public function __construct()
    {

    }

    public function addParcels($parcels)
    {
        if (is_object($parcels)) {
            array_push($this->parcels, $parcels->generateParcel());
            return $this;
        } else {
            array_merge($this->parcels, $parcels);
        }

        return $this;
    }

    public function addItems($items)
    {
        if (is_object($items)) {
            array_push($this->items, $items->generateItem());
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

    public function generateOrder()
    {
        if (!$this->department_shortname) throw new Siusk24LTException('All the fields must be filled. department_shortname is missing.');
        if (!$this->service_code) throw new Siusk24LTException('All the fields must be filled. service_code is missing.');
        if (!$this->sender) throw new Siusk24LTException('All the fields must be filled. sender is missing.');
        if (!$this->receiver) throw new Siusk24LTException('All the fields must be filled. receiver is missing.');
        if (!$this->parcel_type) throw new Siusk24LTException('All the fields must be filled. parcel_type is missing.');
        if (!$this->parcels) throw new Siusk24LTException('All the fields must be filled. parcels are missing.');
        if (!$this->items) throw new Siusk24LTException('All the fields must be filled. items are missing.');
        if (!$this->reference) throw new Siusk24LTException('All the fields must be filled. reference is missing.');
        if (!$this->cod_amount && $this->cod_amount != 0) throw new Siusk24LTException('All the fields must be filled. cod_amount is missing.');

        return array(
            'department_shortname' => $this->department_shortname,
            'service_code' => $this->service_code,
            'sender' => $this->sender->generateSender(),
            'receiver' => $this->receiver->generateReceiver(),
            'parcel_type' => $this->parcel_type,
            'parcels' => $this->parcels,
            'reference' => $this->reference,
            'cod_amount' => $this->cod_amount,
            'items' => $this->items,
            'callback_urls' => $this->callback_urls
        );
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
