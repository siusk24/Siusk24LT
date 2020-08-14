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


    public function __construct($department_shortname, $service_code, $sender, $receiver, $parcel_type, $parcels, $reference, $cod_amount, $items, $callback_urls)
    {
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
