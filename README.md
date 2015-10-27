Listonoska/API
======

[![Latest stable](https://img.shields.io/packagist/v/listonoska/API.svg)](https://packagist.org/packages/Listonoska/API)

Instalace
------------

Nejlepší cesta k instalaci je použití Composeru [Composer](http://getcomposer.org/):

```sh
$ composer require listonoska/API
```

Použití
------------
ukázky použití naleznete ve složce Examples

nejprve je potřeba si získat token:

```PHP
$token = new \Listonoska\API\Token('client_id', 'secret');
$token->getToken(); // vrátí token
```

potom si můžeme získat číselníky:
```PHP
$listOfValues = new Listonoska\API\ListsOfValues($token);
$listOfValues->getDeliveryTypes(); // číselník typů dodání
$listOfValues->getPrintTypes(); // číselník typů tisku
$listOfValues->getIsoCodes(); // číselník iso kódů
```

když už vše víme, tak můžeme odeslat dopis:
```PHP
$data = array(
    'letterName' => 'test',
    'deliveryType' => 169,
    'printType' => 0,
    'senderCompany' => 'firma',
    'senderPerson' => 'Jan Novák',
    'senderStreet' => 'Palackého',
    'senderHouseNumber' => 15,
    'senderOrientationNumber' => 5,
    'senderCity' => 'Praha',
    'senderZip' => '110 00',
    'addresse' => http_build_query(array( //vícerozměrné pole v curl blbne, ale pokud z adres postavíme takto query, tak to listonoška pochopí
	array( // první adresát
	    'person' => 'Radek Novák',
	    'street' => 'Lebedova',
	    'city' => 'Praha',
	    'zip' => '110 00',
        ),
	array( // druhý adresát
	    'person' => 'Radek Novotný',
	    'street' => '17.listopadu',
	    'city' => 'Praha',
	    'zip' => '110 00',
        ),	
    )),
    'pdf1' => new CurlFile( realpath(__DIR__ . '/example.pdf')) // pdf soubor
);

$letter = new Listonoska\API\Letter($token); 
$response = $letter->sendLetter($data); // odešleme dopis, vrátí se nám info o odeslaném dopisu
```

Ještě můžeme získat podací lístek u doporučených dopisů (dodací lístek nemusí být hned dostupný od vašeho podání)
```PHP
$letter = new Listonoska\API\Letter($token); 
$response = $letter->getPostalReceipt($letterId); // id dopisu získáme z odpovědi po odeslání dopisu
```
