<?php

namespace Listonoska\API;

/**
 * @author Jan Matoušek <matousek.vr@gmail.com>
 * @ version 1.0
 */
class Curl 
{
	const CERTIFICATE_PATH = '/Certificate/ca-bundle.crt';
	
	public function curlRequest($url, $postFields, $token = FALSE, $isPost = TRUE){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
		curl_setopt($ch, CURLOPT_HEADER, FALSE);
		curl_setopt($ch, CURLOPT_POST, $isPost);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, TRUE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_CAINFO, __DIR__ . self::CERTIFICATE_PATH);
		
		if($token){
			curl_setopt($ch, CURLOPT_HTTPHEADER, array(
			     "Authorization: Basic $token",
			));	
		}
		
		if($isPost){
			curl_setopt($ch, CURLOPT_POSTFIELDS, $postFields);
		}

		$response = json_decode(curl_exec($ch));
		$error = curl_error($ch);
		
		if($error){
			throw new Exceptions\CurlException($error);
		}
		
		curl_close($ch);	
		
		return $response;
	}
}
