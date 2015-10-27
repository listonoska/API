<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';
session_start();

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

$letter = new Listonoska\API\Letter(isset($_SESSION['listonoska_token']) ? $_SESSION['listonoska_token'] : ''); // záměrně pro ukázku při nenastaveném session nastavíme prázdný token
$response = $letter->sendLetter($data);

if(isset($response->status) && isset($response->code) && $response->status == 'error' && $response->code == 1002){ // pokud se nám vrátí stav, error s kódem chyby 1002 - invalid token
	$token = new \Listonoska\API\Token(CLIENT_ID, SECRET);
	$_SESSION['listonoska_token'] = $token->getToken(); // získáme nový token
	
	$listOfValues = new Listonoska\API\ListsOfValues($_SESSION['listonoska_token']); //a zkusíme poslat dopis znovu
	$response = $letter->sendLetter($data);
}

print_r( $response );