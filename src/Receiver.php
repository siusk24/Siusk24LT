<?php

namespace Siusk24LT;

use Siusk24LT\Person;

use Siusk24LT\Exception\Siusk24LTException;

class Receiver extends Person
{
    private $shipping_type;

    const SHIPPING_TERMINAL = 'terminal';
    const SHIPPING_COURIER = 'courier';

    public $valid_shipping_types;

    public function __construct($shipping_type)
    {

        $this->valid_shipping_types = array(
            self::SHIPPING_COURIER,
            self::SHIPPING_TERMINAL
        );
        $this->setShippingType($shipping_type);
    }

    public function setShippingType($shipping_type)
    {
        if (!in_array($shipping_type, $this->valid_shipping_types)) {
            throw new Siusk24LTException('Unknown shipping type:<br>' . $shipping_type . '. You need to use one of the following types:<br>' . implode(" \n", $valid_shipping_types));
        }
        $this->shipping_type = $shipping_type;


        return $this;
    }


    public function generateReceiver()
    {
        if (!$this->shipping_type) throw new Siusk24LTException('All the fields must be filled. shipping_type is missing.');
        if (!$this->company_name && $this->shipping_type === self::SHIPPING_COURIER) throw new Siusk24LTException('All the fields must be filled. company_name is missing.');
        if (!$this->contact_name) throw new Siusk24LTException('All the fields must be filled. contact_name is missing.');
        if (!$this->street_name && $this->shipping_type === self::SHIPPING_COURIER) throw new Siusk24LTException('All the fields must be filled. street_name is missing.');
        if (!$this->zipcode) throw new Siusk24LTException('All the fields must be filled. zipcode is missing.');
        if (!$this->city && $this->shipping_type === self::SHIPPING_COURIER) throw new Siusk24LTException('All the fields must be filled. city is missing.');
        if (!$this->phone_number) throw new Siusk24LTException('All the fields must be filled. phone_number is missing.');
        if (!$this->country_id) throw new Siusk24LTException('All the fields must be filled. country_id is missing.');



        $receiver = array(
            'shipping_type' => $this->shipping_type,
            'company_name' => $this->company_name,
            'contact_name' => $this->contact_name,
            'street_name' => $this->street_name,
            'city' => $this->city,
            'phone' => $this->phone_number,
            'country_id' => $this->country_id
        );

        if ($this->shipping_type === self::SHIPPING_COURIER)
            $receiver += [ 'zipcode' => $this->zipcode ];
        if ($this->shipping_type === self::SHIPPING_TERMINAL)
            $receiver += [ 'parcel_terminal_zipcode' => $this->zipcode ];

        return $receiver;
    }


    public function generateReceiverOffers()
    {
        if (!$this->zipcode) throw new Siusk24LTException('All the fields must be filled. zipcode is missing.');
        if (!$this->country_id) throw new Siusk24LTException('All the fields must be filled. country_id is missing.');


        return array(
            'zipcode' => $this->zipcode,
            'country_id' => $this->country_id
        );
    }


    public function returnJson()
    {
        return json_encode($this->generateReceiver());
    }

    public function __toArray()
    {
        return $this->generateReceiver();
    }
}
