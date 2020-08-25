<?php

namespace Siusk24LT;

/**
 *
 */
class Person
{
    protected $company_name;
    protected $contact_name;
    protected $street_name;
    protected $zipcode;
    protected $city;
    protected $phone_number;
    protected $country_id;

    public function __construct()
    {

    }

    public function setCompanyName(string $company_name)
    {
        $this->company_name = $company_name;

        return $this;
    }

    public function setContactName(string $contact_name)
    {
        $this->contact_name = $contact_name;

        return $this;
    }

    public function setStreetName(string $street_name)
    {
        $this->street_name = $street_name;

        return $this;
    }

    public function setZipcode(string $zipcode)
    {
        $this->zipcode = $zipcode;

        return $this;
    }

    public function setCity(string $city)
    {
        $this->city = $city;

        return $this;
    }

    public function setPhoneNumber(string $phone_number)
    {
        $this->phone_number = $phone_number;

        return $this;
    }

    public function setCountryId($country_id)
    {
        $this->country_id = $country_id;

        return $this;
    }
}
