<?php

namespace Listonoska\API;

/**
 * @author Jan Matoušek <matousek.vr@gmail.com>
 * @ version 1.0
 */
class ListsOfValues extends Curl 
{
	const REQUEST_URL_DELIVERY_TYPES = 'https://www.listonoska.cz/resources/delivery-types';
	const REQUEST_URL_PRINT_TYPES = 'https://www.listonoska.cz/resources/print-types';
	const REQUEST_URL_ISO = 'https://www.listonoska.cz/resources/iso';
	
	/** @var string */
	private $token;
	
	/** @var StdObject */
	private $deliveryTypes, $printTypes, $isoCodes;
	
	/**
	 * @param string $token
	 */
	public function __construct($token) {
		$this->token = $token;
	}
		
	
	/**
	 * Returns available delivery types
	 * 
	 * @return StdObject
	 * 
	 * @throws Exceptions\CurlException
	 */
	public function getDeliveryTypes(){
		if($this->deliveryTypes){
			return $this->deliveryTypes;
		}
		
		return $this->deliveryTypes = $this->curlRequest(self::REQUEST_URL_DELIVERY_TYPES, FALSE, $this->token, FALSE);
	}
	
	
	/**
	 * Returns available print types
	 * 
	 * @return StdObject
	 * 
	 * @throws Exceptions\CurlException
	 */
	public function getPrintTypes(){
		if($this->printTypes){
			return $this->printTypes;
		}
		
		return $this->printTypes = $this->curlRequest(self::REQUEST_URL_PRINT_TYPES, FALSE, $this->token, FALSE);
	}
	
	
	/**
	 * Returns ISO codes
	 * 
	 * @return StdObject
	 * 
	 * @throws Exceptions\CurlException
	 */
	public function getIsoCodes(){
		if($this->isoCodes){
			return $this->isoCodes;
		}
		
		return $this->isoCodes = $this->curlRequest(self::REQUEST_URL_ISO, FALSE, $this->token, FALSE);
	}	
}