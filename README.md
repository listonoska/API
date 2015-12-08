#Listonoska/API


[![Latest stable](https://img.shields.io/packagist/v/listonoska/API.svg)](https://packagist.org/packages/Listonoska/API)

##Instalace

Nejlepší cesta k instalaci je použitím Composeru [Composer](http://getcomposer.org/):

```sh
$ composer require listonoska/API
```

##Použití

ukázky použití naleznete ve složce Examples

###nejprve je potřeba si získat token:

```PHP
$token = new \Listonoska\API\Token('client_id', 'secret');
$token->getToken(); // vrátí token
```

###potom si můžeme získat číselníky:
```PHP
$listOfValues = new Listonoska\API\ListsOfValues($token);
$listOfValues->getDeliveryTypes(); // číselník typů dodání
$listOfValues->getPrintTypes(); // číselník typů tisku
$listOfValues->getIsoCodes(); // číselník iso kódů
```

###když už vše víme, tak můžeme odeslat dopis:
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
    'addresse' => array( 
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
    ),
    'pdf1' => new CurlFile( realpath(__DIR__ . '/example.pdf')) // pdf soubor
);

$letter = new Listonoska\API\Letter($token); 
$response = $letter->sendLetter($data); // odešleme dopis, vrátí se nám info o odeslaném dopisu
```
U dopisu toho můžeme posílat více. Co vše lze odeslat naleznete v [dokumentaci](http://docs.listonoska.apiary.io/#reference/prace-s-dopisem/odeslani-dopisu/odeslani-dopisu).


###Ještě můžeme získat podací lístek u doporučených dopisů 
(podací lístek nemusí být hned dostupný od vašeho podání)
```PHP
$letter = new Listonoska\API\Letter($token); 
$response = $letter->getPostalReceipt($letterId); // id dopisu získáme z odpovědi po odeslání dopisu
```


###Dopis můžeme stronovat
Pokud je potřeba nějaký dopis zrušit, je možné jej stornovat. Stornovat lze do doby, než bude vyřízen českou poštou. 
```PHP
$letter = new Listonoska\API\ListsOfValues($token);
$response = $letter->cancelLetter($letterId);
```
V případě úspěchu se vrací **$response->cancelled = 1** 

V případě neúspěchu se vrací chybové stavy:
```PHP
$response->status; // error
$response->errors[0]->code; // 1, 2 , 3

// 1 = Letter is already canceled
// 2 = Letter cannot be canceled because is already sent
// 3 = Letter has multiple addresses therefore, can not be canceled
```

**POZOR!!!** Není možné rušit dopisy, kde bylo přiřazeno více adres. Nastával by zde totiž problém, že některé dopisy by mohly být již podané a některé jestě ne. Pokud tedy chcete mít možnost využít tuto funkci, je třeba podávat dopisy vždy s jednou adresou adresáta.

