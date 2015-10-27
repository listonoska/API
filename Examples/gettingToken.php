<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/vendor/autoload.php';
session_start();

$token = new \Listonoska\API\Token(CLIENT_ID, SECRET);
$_SESSION['listonoska_token'] = $token->getToken();
echo $token->getToken();