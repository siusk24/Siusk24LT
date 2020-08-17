<?php

namespace ParcelStars;

use ParcelStars\Person;

use ParcelStars\Exception\ParcelStarsException;

class Receiver extends Person
{
    private $shipping_type;
    private $default_zipcode;
    private $parcel_terminal_zipcode;

    const SHIPPING_TERMINAL = 'terminal';
    const SHIPPING_COURIER = 'courier';

    public $valid_shipping_types;

    public function __construct($shipping_type, $contact_name, $phone_number, $country_id, $zipcode, $company_name = '', $street_name = '', $city = '')
    {
        parent::__construct($company_name, $contact_name, $street_name, $zipcode, $city, $phone_number, $country_id);

        $this->valid_shipping_types = array(
          self::SHIPPING_COURIER,
          self::SHIPPING_TERMINAL
        );
        $this->setShippingType($shipping_type, $company_name, $street_name, $city);

        $this->setZipcode($zipcode);
    }

    public function setShippingType($shipping_type, $company_name = '', $street_name = '', $city = '')
    {
        if (!in_array($shipping_type, $this->valid_shipping_types)) {
            throw new ParcelStarsException('Unknown shipping type:<br>' . $shipping_type . '. You need to use one of the following types:<br>' . implode(" \n", $valid_shipping_types));
        }
        $this->shipping_type = $shipping_type;

        if ($shipping_type === self::SHIPPING_COURIER) {
            if (!$company_name || !$street_name || !$city) {
                throw new ParcelStarsException("Receiver: company name, street name, city is required to perform this action");
            }

            $this->default_zipcode = $this->parcel_terminal_zipcode;
            $this->parcel_terminal_zipcode = '';

            $this->company_name = $company_name;
            $this->street_name = $street_name;
            $this->city = $city;
        }
        if ($shipping_type === self::SHIPPING_TERMINAL) {
            $this->parcel_terminal_zipcode = $this->default_zipcode;
            $this->default_zipcode = '';

            $this->company_name = '';
            $this->street_name = '';
            $this->city = '';
        }

        return $this;
    }


    public function setZipcode($zipcode)
    {
        if ($this->shipping_type === self::SHIPPING_COURIER) {
            $this->default_zipcode = $zipcode;
        }
        if ($this->shipping_type === self::SHIPPING_TERMINAL) {
            $this->parcel_terminal_zipcode = $zipcode;
        }

        return $this;
    }


    private function generateReceiver()
    {
        $receiver = array(
          'shipping_type' => $this->shipping_type,
          'company_name' => $this->company_name,
          'contact_name' => $this->contact_name,
          'street_name' => $this->street_name,
          'zipcode' => $this->default_zipcode,
          'city' => $this->city,
          'phone_number' => $this->phone_number,
          'country_id' => $this->country_id,
          'parcel_terminal_zipcode' => $this->parcel_terminal_zipcode
      );

        return $receiver;
    }

    public function returnObject()
    {
        return $this->generateReceiver();
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
