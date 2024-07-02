<?php
error_reporting(-1);
ini_set('display_errors', 'On');
//PHP JWT example
require_once('vendor/autoload.php');
use \Firebase\JWT\JWT;

class BaoKimAPI {

	/* Bao Kim API key */
	const API_KEY = "v08W9x49BSU5JaL9X9F1YopXWewJZjkH";
	const API_SECRET = "ZCqf7FQ3u3NjuxPzzj88KNx7oxyqBLm5";
	const TOKEN_EXPIRE = 600; //token expire time in seconds
	const ENCODE_ALG = 'HS256';

	private static $_jwt = null;
	/**
	 * Refresh JWT
	 */
	public static function refreshToken(){
		$tokenId    = base64_encode(random_bytes(32));
		$issuedAt   = time();
		$notBefore  = $issuedAt;
		$expire     = $notBefore + self::TOKEN_EXPIRE;

		/*
		 * Payload data of the token
		 */
		$data = [
			'iat'  => $issuedAt,         // Issued at: time when the token was generated
			'jti'  => $tokenId,          // Json Token Id: an unique identifier for the token
			'iss'  => self::API_KEY,     // Issuer
			'nbf'  => $notBefore,        // Not before
			'exp'  => $expire,           // Expire
		];

		/*
		 * Encode the array to a JWT string.
		 * Second parameter is the key to encode the token.
		 *
		 * The output string can be validated at http://jwt.io/
		 */
		self::$_jwt = JWT::encode(
			$data,      //Data to be encoded in the JWT
			self::API_SECRET, // The signing key
			'HS256'     // Algorithm used to sign the token, see https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40#section-3
		);

		return self::$_jwt;
	}

	/**
	 * Get JWT
	 */
	public static function getToken(){
		if(!self::$_jwt)
			self::refreshToken();

		try {
			JWT::decode(self::$_jwt, self::API_SECRET, array('HS256'));
		}catch(Exception $e){
			self::refreshToken();
		}

		return self::$_jwt;
	}
}

//$client = new GuzzleHttp\Client(['timeout' => 20.0]);
//$options['query']['jwt'] = BaoKimAPI::getToken();
//
//$options['form_params'] = [
//	'mrc_order_id'=>'ABCD_'.time(),
//	'total_amount'=>'120000',
//	'description'=>'dbt test',
//	'url_success'=>'https://www.baidu.com/',
//	'bpm_id'=>'97',
//	'merchant_id'=>'40053',
//	'customer_email'=>'1@bk.vn',
//	'customer_phone'=>'0943972259',
//	'customer_name'=>'1@bk.vn',
//	'customer_address'=>'102, Thái Thịnh, phường Trung Liệt, quận Đống Đa.'
//];
//
////echo '<pre>'.print_r($options, true).'</pre>';die();
//
//$response = $client->request("POST", "https://dev-api.baokim.vn/payment/api/v5/order/send", $options);
//$dataResponse = json_decode($response->getBody()->getContents());
//
//echo "Response status code: " . $response->getStatusCode();
//echo "<br/>";
//echo "Response data: ";
//echo '<pre>'.print_r($dataResponse, true).'</pre>';die();