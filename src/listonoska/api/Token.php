<?php

namespace Listonoska\API;

/**
 * @author Jan Matoušek <matousek.vr@gmail.com>
 * @ version 1.0
 */
class Token extends Curl
{
	
	const REQUEST_URL = 'https://www.listonoska.cz/oauth-token';
	
	/** @var string */
	private $client;
	
	/** @var string */
	private $secret;
	
	/** @var string */
	private $token = FALSE;
	
	/** @var string */
	private $refreshToken = FALSE;
	
	/** @var int */
	private $expireTime = FALSE;

	
	/**
	 * @param string $client
	 * @param string $secret
	 */
	public function __construct($client, $secret) {
		$this->client = $client;
		$this->secret = $secret;
	}
	
	
	/**
	 * Returns access token
	 * 
	 * @return string
	 * 
	 * @throws Exceptions\CurlException
	 * @throws Exceptions\AuthException
	 */
	public function getToken(){
		if($this->token){
			return $this->token;
		}
		
		$this->createRequest();
		
		return $this->token;
	}
	
	
	/**
	 * Returns refresh token
	 * 
	 * @return string
	 * 
	 * @throws Exceptions\CurlException
	 * @throws Exceptions\AuthException
	 */
	public function getRefreshToken(){
		if($this->token){
			return $this->refreshToken;
		}
		
		$this->createRequest();
		
		return $this->refreshToken;
	}
	
	
	/**
	 * returns expire time
	 * 
	 * @return int
	 * 
	 * @throws Exceptions\CurlException
	 * @throws Exceptions\AuthException
	 */
	public function getExpireTime(){
		if($this->token){
			return $this->expireTime;
		}
		
		$this->createRequest();
		
		return $this->expireTime;
	}
	
	
	/**
	 * @throws Exceptions\CurlException
	 * @throws Exceptions\AuthException
	 */
	private function createRequest(){
		$response = $this->curlRequest(self::REQUEST_URL, array(
		    'client_id' => $this->client,
		    'client_secret' => $this->secret,
		));
			
		if(isset($response->access_token)){
			$this->token = $response->access_token;
			$this->refreshToken = $response->refresh_token;
			$this->expireTime = $response->expires_in;
		} else {
			throw new Exceptions\AuthException($response->error_description);
		}
	}
}