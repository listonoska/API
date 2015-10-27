<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';
session_start();

$listOfValues = new Listonoska\API\ListsOfValues(isset($_SESSION['listonoska_token']) ? $_SESSION['listonoska_token'] : ''); // záměrně pro ukázku při nenastaveném session nastavíme prázdný token
$deliveryTypes = $listOfValues->getDeliveryTypes();

if(isset($deliveryTypes->status) && isset($deliveryTypes->code) && $deliveryTypes->status == 'error' && $deliveryTypes->code == 1002){ // pokud se nám vrátí stav, error s kódem chyby 1002 - invalid token
	$token = new \Listonoska\API\Token(CLIENT_ID, SECRET);
	$_SESSION['listonoska_token'] = $token->getToken(); // získáme nový token
	
	$listOfValues = new Listonoska\API\ListsOfValues($_SESSION['listonoska_token']); //vytvoříme novou instanci číselníků
	$deliveryTypes = $listOfValues->getDeliveryTypes(); // znovu si získáme dodací možnosti
}

print_r( $deliveryTypes );
print_r( $listOfValues->getPrintTypes() );
print_r( $listOfValues->getIsoCodes() );