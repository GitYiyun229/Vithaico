<?php
//defined('ABSPATH') || exit;

//ini_set('memory_limit', '-1');
//ini_set('max_excution_time', '-1');
//ini_set('display_errors', '1');
//ini_set('display_errors', '1');
//ini_set('display_startup_errors', '1');
//error_reporting(E_ALL);

require './vendor/autoload.php';

//Insert into Google Sheets Code
$client = new \Google_Client();
$client->setApplicationName('prosamoste');
$client->setScopes([\Google_Service_Sheets::SPREADSHEETS]);
$client->setAccessType('offline');
$client->setAuthConfig('./credential.json');

$service = new Google_Service_Sheets($client);
$spreadsheetId = "1Tc7cO_rMlikKnSI3z9nKcrxFgHHKW4NaLQMoV6isPhs";
$range = "ddtm-merchant";


$params = [
    'valueInputOption' => 'RAW'
];

$insert = [
    'insertDataOptions' => 'INSERT_ROWS'
];

$value = [
    ['cuong1' ,'alo 1234'],
    ['cuong2' ,'alo 1234'],
    ['cuong3' ,'alo 1234']
];

$body = new Google_Service_Sheets_ValueRange([
    'values' => $value
]);

$params = [
    'valueInputOption' => 'RAW'
];

$service->spreadsheets_values->clear(
    $spreadsheetId,
    'A2:D',
    $body1 = new Google_Service_Sheets_ClearValuesRequest()
);


$result = $service->spreadsheets_values->append(
    $spreadsheetId,
    $range,
    $body,
    $params
);

if($result->updates->updatedRows != 0){
    echo 'Success';
} else{
    echo 'Fail';
}


?>