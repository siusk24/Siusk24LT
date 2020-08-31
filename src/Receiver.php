<?php

namespace Siusk24LT;

use Siusk24LT\Person;

use Siusk24LT\Exception\Siusk24LTException;

class Receiver extends Person
{


    public function __construct($shipping_type)
    {
        parent::__construct($shipping_type);
    }




    public function generateReceiver()
    {
        if (!$this->shipping_type) throw new Siusk24LTException('All the fields must be filled. shipping_type is missing.');
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
