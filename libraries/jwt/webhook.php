<?php

$jsonWebhookData = file_get_contents('php://input');

$webhookData = json_decode($jsonWebhookData, true);
//echo '<pre>'.print_r($webhookData, true).'</pre>';die();
$baokimSign = $webhookData['sign'];
unset($webhookData['sign']);

$signData = json_encode($webhookData);

$secret = "2b50f78656424ce8b13c43c88e9674ca";
$mySign = hash_hmac('sha256', $signData, $secret);

if($baokimSign == $mySign)
    echo "Signature is valid";
else
    echo "Signature is invalid aaa";


die;