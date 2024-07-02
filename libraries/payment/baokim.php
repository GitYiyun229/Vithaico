<?php
/**
 * Created by PhpStorm.
 * User: ANH DUNG
 * Date: 12/6/2021
 * Time: 9:39 AM
 */

require_once('../jwt/vendor/autoload.php');
use \Firebase\JWT\JWT;

class BaoKimAPI {

    /* Bao Kim API key */
    const API_KEY = "a18ff78e7a9e44f38de372e093d87ca1";
    const API_SECRET = "9623ac03057e433f95d86cf4f3bef5cc";
    const TOKEN_EXPIRE = 60; //token expire time in seconds
    const ENCODE_ALG = 'HS256';

    private static $_jwt = null;

    /**
     * Refresh JWT
     */
    public static function refreshToken(){

        $tokenId    = base64_encode(mcrypt_create_iv(32));
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