<?php

namespace ParcelStars;

use ParcelStars\Exception\ParcelStarsException;
use ParcelStars\Exception\ValidationException;

class API
{
    protected $url = "https://demo.parcelstars.com/api/";
    protected $token;

    public function __construct($token = false, $test_mode = false)
    {
        if (!$token) {
            throw new ParcelStarsException("ParcelStars user Token is required");
        }

        $this->token = $token;

        if (!$test_mode) {
            $this->url =  "https://www.parcelstars.com/api/";
        }
    }





    private function callAPI($url, $data = [])
    {
        $ch = curl_init();

        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
      "Authorization: Bearer ".$this->token
    ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

        if ($data) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        }

        $response = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        curl_close($ch);

        //echo json_encode($data);

        return $this->handleApiResponse($response, $httpCode);
    }

    private function handleApiResponse($response, $httpCode)
    {
        if ($httpCode == 200) {
            return json_decode($response)->result;
        }

        if ($httpCode == 401) {
            throw new ParcelStarsException(implode(" \n", json_decode($response)->errors));
        }

        $errors = json_decode($response, true);

        if (isset($errors['messages'])) {
            echo 'messages:<br><br>';
            echo $response;
            echo '<br><br>';
            throw new ValidationException(implode(", \n", $errors['messages'][0]));
        }

        if (isset($errors['error'])) {
            echo 'errors:<br><br>';
            //echo $response;
            throw new ValidationException($errors['error']);
        }

        throw new ParcelStarsException('API responded with error: ' . $response);
    }






    public function listAllCountries()
    {
        $response = $this->callAPI($this->url . 'services/countries');

        return $response->countries;
    }

    public function getDepartments()
    {
        $response = $this->callAPI($this->url . 'departments');

        return $response->departments;
    }

    public function listAllServices()
    {
        $response = $this->callAPI($this->url . 'services');

        return $response->services;
    }

    public function getAllOrders()
    {
        $response = $this->callAPI($this->url . 'orders');

        return $response->orders;
    }

    public function getLabel($shipment_id)
    {
        $response = $this->callAPI($this->url . "orders/".$shipment_id."/label");

        return $response;
    }

    public function generateManifest($shipment_ids)
    {
        $post_data = array( 'shipments' => $shipment_ids );
        $response = $this->callAPI($this->url . 'manifests', $post_data);

        return $response;
    }

    public function getTerminals($country_code)
    {
        $response = $this->callAPI($this->url . 'terminals/' . $country_code);

        return $response->terminals;
    }

    public function generateOrder($order)
    {
        $post_data = $order->__toArray();
        $response = $this->callAPI($this->url . 'orders', $post_data);

        return $response;
    }

    public function generateOrder_parcelTerminal($order)
    {
        $post_data = $order->__toArray();
        $response = $this->callAPI($this->url . 'orders', $post_data);

        return $response;
    }

    public function cancelOrder()
    {
        $response = $this->callAPI($this->url . 'orders/'.$shipment_id.'/cancel');

        return $response;
    }

    public function makePickup($shipment_id)
    {
        $response = $this->callAPI($this->url . 'orders/'.$shipment_id.'/pickup');

        return $response;
    }

    public function trackOrder($shipment_id)
    {
        $response = $this->callAPI($this->url . 'orders/'.$shipment_id.'/track');

        return $response;
    }
}
