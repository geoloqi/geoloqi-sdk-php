<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require('../Geoloqi.php');

$geoloqi = GeoloqiSession::createWithAccessToken('YOUR ACCESS TOKEN GOES HERE');

$response = $geoloqi->get('account/profile');

echo("Response for GET account/profile:<br>");
htmlspecialchars(print_r($response));

echo("<br><br>Response for POST account/profile:<br>");

$response = $geoloqi->post('account/profile', array('website' => 'http://limpbizkitfanclub.net'));
print_r($response);
?>