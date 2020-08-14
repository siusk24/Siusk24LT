 # ParcelStars API-lib

Its a library for ParcelStars API.

## Using ParcelStars API-lib
- This will load ParcelStars\API-lib namespace
```php
require parcelstars/api-lib;
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
use ParcelStars\API;
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
use ParcelStars\API;
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
`use ParcelStars\Item;` will allow to create Parcel object.

Minimum required setup:

```php
use ParcelStars\API;
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


## Create Shipment
---
Available product codes:
* Shipment::PRODUCT_COURIER = 2317
* Shipment::PRODUCT_PICKUP  = 2711

Shipment can be either one, but never both. See Additional Services for what services is available to each product code.

**Shipment product code should always be set first.**

When registering GoodsItem its possible to register one at a time using
`$shipment->addGoodsItem(GoodsItem)`
or multiple passing them in array to
`$shipment->addGoodsItems(array(GoodsItem, GoodsItem))`

When registering AdditionalService its possible to register one at a time using
`$shipment->addAdditionalService(AdditionalService)`
or multiple passing them in array to
`$shipment->addAdditionalServices(array(AdditionalService, AdditionalService))`


Courier Shipment example (uses variables from above examples):
```php
use Mijora\Itella\Shipment\Shipment;
use Mijora\Itella\ItellaException;

try {
  $shipment = new Shipment($p_user, $p_secret);
  $shipment
    ->setProductCode(Shipment::PRODUCT_COURIER) // product code, should always be set first
    ->setShipmentNumber('Test_ORDER')           // shipment number, Order ID is good here
    ->setSenderParty($sender)                   // Register Sender
    ->setReceiverParty($receiver)               // Register Receiver
    ->addAdditionalServices(                    // Register additional services
      array($service_fragile, $service_cod)
    )
    ->addGoodsItems(                            // Register GoodsItem
      array($item)
    )
  ;
} catch (ItellaException $e) {
  // Handle validation exceptions here
}
```

Pickup point Shipment example (uses variables from above examples):
```php
use Mijora\Itella\Shipment\Shipment;
use Mijora\Itella\ItellaException;

$user = 'API_USER';     // API user
$secret = 'API_SECRET'; // API secret / password

try {
  $shipment = new Shipment($user, $secret);
  $shipment
    ->setProductCode(Shipment::PRODUCT_PICKUP)  // product code, should always be set first
    ->setShipmentNumber('Test_ORDER')           // shipment number, Order ID is good here
    ->setSenderParty($sender)                   // Register Sender
    ->setReceiverParty($receiver)               // Register Receiver
    ->setPickupPoint('071503201')               // Register pickup point pupCode
    ->addGoodsItem($item)                       // Register GoodsItem (this adds just one)
  ;
} catch (ItellaException $e) {
  // Handle validation exceptions here
}
```

Once all information is supplied - shipment can be registered.
If registration is successfull, tracking number will be returned.
In this example returned tracking number is displayed, normaly it would be saved to order for later use to request shipment label PDF.
```php
try {
  $tracking_number = $shipment->registerShipment();
  echo "Shipment registered:\n <code>" . $tracking_number . "</code>\n";
} catch (ItellaException $e) {
  // Handle validation exceptions here
}
```

If there is need to check request XML it can be done using `asXML()`
```php
try {
  $xml = $shipment->asXML();
  file_put_contents('request.xml', $xml);
} catch (ItellaException $e) {
  // Handle validation exceptions here
}
```

## Printing Label
---
It is advised to always download label when it is needed. For that Shipment class is used.
result will be base64 encoded pdf file. If multiple tracking numbers (in array) is passed pdf will contain all those labels. For getting and merging labels pdf from two different users please refer to `get-merge-labels.php` example

**Important**: If tracking number is from different user it will be ignored.
```php
use Mijora\Itella\Shipment\Shipment;
use Mijora\Itella\ItellaException;

$user = 'API_USER';     // API user
$secret = 'API_SECRET'; // API secret / password

$track = 'JJFI12345600000000001';
// or if need multiple in one pdf
// $track = ['JJFI12345600000000001', 'JJFI12345600000000010'];

try {
  $shipment = new Shipment($user, $secret);
  $pdf_base64 = $shipment->downloadLabels($track);
  $pdf = base64_decode($pdf_base64);
  if ($pdf) { // check if its not empty
    if (is_array($track)) {
      $track = 'labels';
    }
    $path = $track . '.pdf';
    $is_saved = file_put_contents($path, $pdf);
    $filename = 'labels.pdf';
    if (!$is_saved) { // make sure it was saved
      throw new ItellaException("Failed to save label pdf to: " . $path);
    }

    // make sure there is nothing before headers
    if (ob_get_level()) ob_end_clean();
    header("Content-Type: application/pdf; name=\"{$filename}\"");
    header("Content-Transfer-Encoding: binary");
    // disable caching on client and proxies, if the download content vary
    header("Expires: 0");
    header("Cache-Control: no-cache, must-revalidate");
    header("Pragma: no-cache");
    readfile($path);
  } else {
    throw new ItellaException("Downloaded label data is empty.");
  }
} catch (ItellaException $e) {
  echo "Exception: <br>\n" . $e->getMessage() . "<br>\n";
}
```
Above example checks that response isnt empty (if tracking number is wrong it still returns empty response), saves to file and loads into browser.


## Locations API
---
When using Pickup Point option it is important to have correct list of pickup points. Also when creating Shipment to send to pickup point it will require that pickup point ID.
```php
use Mijora\Itella\Locations\PickupPoints;

$pickup = new PickupPoints('https://locationservice.posti.com/api/2/location');
// it is advised to download locations for each country separately
// this will return filtered pickup points list as array
$itella_loc = $pickup->getLocationsByCountry('LT');
// now points can be stored into file or database for future use
$pickup->saveLocationsToJSONFile('itella_locations_lt.json', json_encode($itella_oc));
```

## Manifest generating
---
When generating manifest by default it uses english strings - it is possible to pass translation.

Manifest constructor accepts additional arguments
  - `$timestamp`  => default `false` and will assign current system time. Unixtimestamp can be passed here to show particular date in manifest above logo.
  - `$dateFormat` => default `'Y-m-d'`. Date format as string, can be used anything that is supported by PHP date() https://www.php.net/manual/en/function.date

**Requires** array of arrays with this information:
  - `track_num`         => tracking number (string),
  - `weight`            => weight (if any) (float),
  - `delivery_address`  => Delivery address (string).

for other options see example below:
```php
use Mijora\Itella\Pdf\Manifest;

$items = array(
  array(
    'track_num' => 'JJFItestnr00000000015',
    'weight' => 1,
    'delivery_address' => 'Testas Testutis, Pramones pr. 6, 51267 Kaunas, LT',
  ),
);

// If need to translate default english
$translation = array(
  'sender_address' => 'Siuntėjo adresas:',
  'nr' => 'Nr.',
  'track_num' => 'Siuntos numeris',
  'date' => 'Data',
  'amount' => 'Kiekis',
  'weight' => 'Svoris (kg)',
  'delivery_address' => 'Pristatymo adresas',
  'courier' => 'Kurjerio',
  'sender' => 'Siuntėjo',
  'name_lastname_signature' => 'vardas, pavardė, parašas',
);

$manifest = new Manifest();
$manifest
  ->setStrings($translation) // set translation
  ->setSenderName('TEST Web Shop') // sender name
  ->setSenderAddress('Raudondvario pl. 150') // sender address
  ->setSenderPostCode('47174') // sender postcode
  ->setSenderCity('Kaunas') // sender city
  ->setSenderCountry('LT') // sender country code
  ->addItem($items) // register item list
  ->setToString(true) // if requires pdf to be returned as string set to true (default false)
  ->setBase64(true) // when setToString is true, this one can set if string should be base64 encoded (default false)
  ->printManifest('manifest.pdf', 'PATH_TO_SAVE'); // set filename as first argument and path where to save it if setToStringis false
```

## Call Courier
---
To call courrier manifest must be generated (works well with base64 encoded pdf). CallCourier is using mail() php function. That means - even if mail reports success on sending email, it is not guaranteed to be sent.
```php
use Mijora\Itella\CallCourier;
use Mijora\Itella\ItellaException;
use Mijora\Itella\Pdf\Manifest;

$manifest = new Manifest();
$manifest_string = $manifest
  /*
  See previous examples on how to create manifest, here only show last couple settings to get base64 string
  */
  ->setToString(true)
  ->setBase64(true)
  ->printManifest('manifest.pdf')
;

$sendTo = 'test@test.com'; // email to send courier call to
try {
  $caller = new CallCourier($sendTo);
  $result = $caller
    ->setSenderEmail('shop@shop.lt') // sender email
    ->setSubject('E-com order booking') // currently it must be 'E-com order booking'
    ->setPickUpAddress(array( // strings to show in email message
      'sender' => 'Name / Company name',
      'address' => 'Street, Postcode City, Country',
      'contact_phone' => '865465412',
    ))
    ->setAttachment($manifest_string, true) // attachment is previously generated manifest, true - means we are passing base64 encoded string
    ->callCourier() // send email
  ;
  if ($result) {
    echo 'Email sent to: <br>' . $sendTo;
  }
} catch (ItellaException $e) { // catch if something goes wrong
  echo 'Failed to send email, reason: ' . $e->getMessage();
}
```
