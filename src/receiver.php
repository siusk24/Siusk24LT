<?php

namespace ParcelStars;

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
