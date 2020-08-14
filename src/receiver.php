<?php

namespace ParcelStars;

use ParcelStars\Exception\ParcelStarsException;

/**
 *
 */
class Receiver
{
    private $shipping_type;
    private $company_name;
    private $contact_name;
    private $street_name;
    private $zipcode = '';
    private $city;
    private $phone_number;
    private $country_id;
    private $parcel_terminal_zipcode = '';

    public function __construct($shipping_type, $contact_name, $phone_number, $country_id, $zipcode, $company_name = '', $street_name = '', $city = '')
    {
        if ($shipping_type === 'courier') {
            $this->zipcode = $zipcode;
        }
        if ($shipping_type === 'terminal') {
            $this->parcel_terminal_zipcode = $zipcode;
        }
        $this->shipping_type = $shipping_type;
        $this->company_name = $company_name;
        $this->contact_name = $contact_name;
        $this->street_name = $street_name;
        $this->city = $city;
        $this->phone_number = $phone_number;
        $this->country_id = $country_id;
    }

    public function setShippingType($shipping_type, $company_name = '', $street_name = '', $city = '')
    {
        $this->shipping_type = $shipping_type;

        if ($shipping_type === 'courier') {
            $this->zipcode = $this->parcel_terminal_zipcode;
            $this->parcel_terminal_zipcode = '';

            if (!$company_name || !$street_name || !$city) {
                throw new ParcelStarsException("Receiver: company name, street name, city is required to perform this action");
            }

            $this->company_name = $company_name;
            $this->street_name = $street_name;
            $this->city = $city;
        }
        if ($shipping_type === 'terminal') {
            $this->parcel_terminal_zipcode = $this->$zipcode;
            $this->zipcode = '';

            $this->company_name = '';
            $this->street_name = '';
            $this->city = '';
        }

        return $this;
    }

    public function setCompanyName($company_name)
    {
        $this->company_name = $company_name;

        return $this;
    }

    public function setContactName($contact_name)
    {
        $this->contact_name = $contact_name;

        return $this;
    }

    public function setStreetName($street_name)
    {
        $this->street_name = $street_name;

        return $this;
    }

    public function setZipcode($zipcode)
    {
        if ($shipping_type === 'courier') {
            $this->zipcode = $zipcode;
        }
        if ($shipping_type === 'terminal') {
            $this->parcel_terminal_zipcode = $zipcode;
        }

        return $this;
    }

    public function setCity($city)
    {
        $this->city = $city;

        return $this;
    }

    public function setPhoneNumber($phone_number)
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function setCountryId($country_id)
    {
        $this->country_id = $country_id;

        return $this;
    }

    private function generateReceiver()
    {
        $receiver = array(
          'shipping_type' => $this->shipping_type,
          'company_name' => $this->company_name,
          'contact_name' => $this->contact_name,
          'street_name' => $this->street_name,
          'zipcode' => $this->zipcode,
          'city' => $this->city,
          'phone_number' => $this->phone_number,
          'country_id' => $this->country_id,
          'parcel_terminal_zipcode' => $this->parcel_terminal_zipcode
      );

        return $receiver;
    }

    public function return_object()
    {
        return $this->generateReceiver();
    }

    public function return_json()
    {
        return json_encode($this->generateReceiver());
    }

    public function __toArray()
    {
        return $this->generateReceiver();
    }
}
