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

$sender = new Sender('TEST',          // company name
                     'TEST',          // contact name
                     'TEST',          // street name
                     '48311',         // zip code
                     'TEST',          // city
                     '+37061234567',  // phone number
                     122);            // country id

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
  $receiver1 = new Receiver('courier',          // shipping type
                            'TEST',             // contact name
                            '+37061234567',     // phone number
                            116,                // country id
                            '12-345',           // zip code
                            'TEST',             // company name
                            'TEST',             // street name
                            'TEST');            // city

  $receiver2 = new Receiver('terminal',         // shipping type
                            'TEST',             // contact name
                            '+37061234567',     // phone number
                            116,                // country id
                            '12-345');          // zip code

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
    ->setShippingType('courier', 'company_name', 'street_name', 'city')
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

$parcel = new Parcel( 2,       // amount
                      1,       // unit weight
                      20,      // width   
                      20,      // length
                      20);     // heigth
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

$item = new Item( 'test package',  // description
                  5,               // item price
                  1);              // item amount
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

$sender = new Sender(     'TEST',           // company name
                          'TEST',           // contact name
                          'TEST',           // street name
                          '48311',          // zip code
                          'TEST',           // city
                          '+37061234567',   // phone number
                          122);             // country id

$receiver = new Receiver('courier',         // shipping type
                          'TEST',           // contact name
                          '+37061234567',   // phone number
                          116,              // country id
                          '12-345',         // zip code
                          'TEST',           // company name
                          'TEST',           // street name
                          'TEST');          // city

$parcel1 = new Parcel(    2,                // amount
                          1,                // unit weight
                          20,               // width   
                          20,               // length
                          20);              // heigth

$parcel2 = new Parcel(    2,                // amount
                          1,                // unit weight
                          20,               // width   
                          20,               // length
                          20);              // heigth

$parcels = array($parcel1, $parcel2);

$item1 = new Item(        'test package',   // description
                          5,                // item price
                          1);               // item amount

$item2 = new Item(        'test package',   // description
                          5,                // item price
                          1);               // item amount

$items = array($item1, $item2);

$callback_urls = array("www.1.com/cb", "www.2.com/cb");

$order = new Order(       'ZIPAS',          // department short name
                          'PS1',            // service code
                          $sender,          // sender
                          $receiver,        // receiver
                          'parcel',         // parcel type
                          $parcels,         // parcels
                          'test package',   // reference
                          0,                // cod amount
                          $items,           // items
                          $callback_urls);  // callback url array - optional

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
