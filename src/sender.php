<?php

namespace ParcelStars;

/**
 *
 */
class Sender
{
    private $company_name = '';
    private $contact_name = '';
    private $street_name = '';
    private $zipcode = '';
    private $city = '';
    private $phone_number = '';
    private $country_id = -1;

    public function __construct($company_name, $contact_name, $street_name, $zipcode, $city, $phone_number, $country_id)
    {
        $this->company_name = $company_name;
        $this->contact_name = $contact_name;
        $this->street_name = $street_name;
        $this->zipcode = $zipcode;
        $this->city = $city;
        $this->phone_number = $phone_number;
        $this->country_id = $country_id;
    }

    private function generateSender()
    {
        $sender = array(
          'company_name' => $this->company_name,
          'contact_name' => $this->contact_name,
          'street_name' => $this->street_name,
          'zipcode' => $this->zipcode,
          'city' => $this->city,
          'phone_number' => $this->phone_number,
          'country_id' => $this->country_id
      );

        return $sender;
    }

    public function return_object()
    {
        return $this->generateSender();
    }

    public function return_json()
    {
        return $this->json_encode(generateSender());
    }

    public function __toArray()
    {
        return $this->generateSender();
    }
}
