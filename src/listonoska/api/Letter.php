<?php

namespace Listonoska\API;

/**
 * @author Jan Matoušek <matousek.vr@gmail.com>
 * @ version 1.1
 */
class Letter extends Curl 
{
	const REQUEST_URL_SEND_LETTER = 'https://www.listonoska.cz/resources/send-letter';
	const REQUEST_URL_POSTAL_RECEIPT = 'https://www.listonoska.cz/resources/postal-receipt/';
	
	/** @var string */
	private $token;
	
	
	/**
	 * @param string $token
	 */
	public function __construct($token) {
		$this->token = $token;
	}
		
	
	/**
	 * Sends letter via listonsoka.cz
	 * 
	 * @param array $fields
	 * 
	 * @return StdObject
	 * 
	 * @throws Exceptions\CurlException
	 */
	public function sendLetter($fields){
		
		if(isset($fields['addresse'])){
			$fields['addresse'] = http_build_query($fields['addresse'] ); // fix for curl
		}
		
		return $this->curlRequest(self::REQUEST_URL_SEND_LETTER, $fields, $this->token);
	}
	
		
	/**
	 * Returns postal receipt pdf encoded in base 64
	 * 
	 * @param int $letterId
	 * 
	 * @return StdObject
	 * 
	 * @throws Exceptions\CurlException
	 */
	public function getPostalReceipt($letterId){
		return $this->curlRequest(self::REQUEST_URL_POSTAL_RECEIPT . $letterId, FALSE, $this->token, FALSE);
	}	
}