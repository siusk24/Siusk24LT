 # ParcelStars API-lib

Its a library for ParcelStars API.

## Using ParcelStars API-lib
- ```__PATH_TO_LIB__``` is a path where ParcelStars API is placed. This will load ParcelStars namespace
```php
require(__PATH_TO_LIB__ . "ParcelStars/vendor/autoload.php");
```

Validations, checks, etc. throws `ParcelStarsException` and calls to library classes should be wrapped in: blocks
```php
try {
  // ...
} catch (ParcelStarsException $e) {
  // ...
}
```

Any function starting with `add` or `set` returns its class so functions can be chained.

## Authentication
---
Uses supplied user `$token` and `(bool) $test_mode`, which if set to true will let you use Demo API or if set to false or not provided will use production API. It is called during API object creation.
- Initialize new API library using: `$ps = new API($token, true);`
- Set new token using: `$ps->setToken($token);`


## Creating and Editing Sender
---
`use ParcelStars\Sender;` will allow to create Sender object.

Minimum required setup:

```php
use ParcelStars\Sender;

$sender = new Sender();

$sender
  ->setCompanyName('company_name')
  ->setContactName('contact_name')
  ->setStreetName('street_name')
  ->setZipcode('zipcode')
  ->setCity("city")
  ->setPhoneNumber('phone_number')
  ->setCountryId('country_id');
```


## Creating Receiver
---
`use ParcelStars\Receiver;` will allow to create Receiver object.

Minimum required setup:
- shipping type must be either "courier" or "terminal"

```php
use ParcelStars\Receiver;

try {
  $receiver1 = new Receiver();

  $receiver2 = new Receiver();

  $receiver1
    ->setShippingType('terminal')
    ->setCompanyName('company_name')
    ->setContactName('contact_name')
    ->setStreetName('street_name')
    ->setZipcode('zipcode')
    ->setCity('city')
    ->setPhoneNumber('phone_number')
    ->setCountryId('country_id');

  $receiver2
    ->setShippingType('courier')
    ->setCompanyName('company_name')
    ->setContactName('contact_name')
    ->setStreetName('street_name')
    ->setZipcode('zipcode')
    ->setCity('city')
    ->setPhoneNumber('phone_number')
    ->setCountryId('country_id');

} catch (ItellaException $e) {
  // Handle validation exceptions here
}
```

## Creating Parcel
---
`use ParcelStars\Parcel;` will allow to create Parcel object.

Minimum required setup:

```php
use ParcelStars\Parcel;

$parcel = new Parcel();=
$parcel
    ->setAmount(2)
    ->setUnitWeight(1)
    ->setWidth(20)
    ->setLength(20)
    ->setHeight(20);
```

## Creating Item
---
`use ParcelStars\Item;` will allow to create Item object.

Minimum required setup:

```php
use ParcelStars\API;
use ParcelStars\Sender;

$item = new Item();
$item
  ->setDescription('description')
  ->setItemPrice(5)
  ->setItemAmount(1)
```


## Creating Order
---

```php
use ParcelStars\API;
use ParcelStars\Sender;
use ParcelStars\Receiver;
use ParcelStars\Item;
use ParcelStars\Parcel;
use ParcelStars\Order;

$sender = new Sender();
$sender
    ->setCompanyName('TEST')
    ->setContactName('TEST')
    ->setStreetName('TEST')
    ->setZipcode('48311')
    ->setCity("TEST")
    ->setPhoneNumber('37061234567')
    ->setCountryId('122');

$receiver = new Receiver('courier');

$parcel1 = new Parcel();
$parcel1
        ->setAmount(2)
        ->setUnitWeight(1)
        ->setWidth(20)
        ->setLength(20)
        ->setHeight(20);

$parcel2 = new Parcel(); 
$parcel2
        ->setAmount(3)
        ->setUnitWeight(2)
        ->setWidth(20)
        ->setLength(20)
        ->setHeight(20);

$parcels = array($parcel1, $parcel2);

$item1 = new Item();
$item1
    ->setDescription('test package')
    ->setItemPrice(5)
    ->setItemAmount(1);
$item2 = new Item();
$item2
    ->setDescription('test package')
    ->setItemPrice(1)
    ->setItemAmount(3);

$items = array($item1, $item2);

$callback_urls = array("www.1.com/cb", "www.2.com/cb");

$order = new Order();

$order
  ->setDepartmentShortname($department_shortname)
  ->setServiceCode($service_code)
  ->setSender($sender)
  ->setReceiver($receiver)
  ->setParcelType($parcel_type)
  ->setParcels($parcels)
  ->setReference($reference)
  ->setCodAmount($cod_amount)
  ->setItems($items)
  ->setCallbackUrls($callback_urls)
```

When creating Order it is possible to register a single item or parcel, by passing it without array.
`$order->setParcels($parcel1)->setItems($item1);`
It is also possible to add additional items

## Calling API
---
- check **src/examples/index.php** for Calling this API examples.
