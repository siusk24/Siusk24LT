<?php

namespace ParcelStars;

use ParcelStars\Person;

/**
 *
 */
class Sender extends Person
{
    public function __construct($company_name, $contact_name, $street_name, $zipcode, $city, $phone_number, $country_id)
    {
        parent::__construct($company_name, $contact_name, $street_name, $zipcode, $city, $phone_number, $country_id);
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

    public function returnObject()
    {
        return $this->generateSender();
    }

    public function returnJson()
    {
        return $this->json_encode(generateSender());
    }

    public function __toArray()
    {
        return $this->generateSender();
    }
}
