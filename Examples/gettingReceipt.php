<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';
session_start();

$letterId = 1;

$letter = new Listonoska\API\Letter(isset($_SESSION['listonoska_token']) ? $_SESSION['listonoska_token'] : ''); // záměrně pro ukázku při nenastaveném session nastavíme prázdný token
$response = $letter->getPostalReceipt($letterId);

if(isset($response->status) && isset($response->code) && $response->status == 'error' && $response->code == 1002){ // pokud se nám vrátí stav, error s kódem chyby 1002 - invalid token
	$token = new \Listonoska\API\Token(CLIENT_ID, SECRET);
	$_SESSION['listonoska_token'] = $token->getToken(); // získáme nový token
	
	$listOfValues = new Listonoska\API\ListsOfValues($_SESSION['listonoska_token']);
	$response = $letter->getPostalReceipt($letterId);
}

print_r( $response ); // dodací lístek se vrací jen u doporučených dopisů. Dodací lístek také nelze stáhnout ihned po odeslání dopisu, ale až poté, co dopis zpracujeme (bude vracet sent = 1)