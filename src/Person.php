<?php

namespace Siusk24LT;

/**
 *
 */
class Person
{
    protected string $company_name;
    protected string $contact_name;
    protected string $street_name;
    protected string $zipcode;
    protected string $city;
    protected string $phone_number;
    protected int $country_id;

    public function __construct()
    {
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
        $this->zipcode = $zipcode;

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
}
