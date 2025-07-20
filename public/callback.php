<?php
session_start();
require_once __DIR__ . '/../lib/db.php';
$config = require __DIR__ . '/../config/config.php';

if ($_GET['state'] !== $_SESSION['oauth_state']) {
    die('Invalid state');
}

$code = $_GET['code'];

$ch = curl_init("https://api.etsy.com/v3/public/oauth/token");
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
    'grant_type' => 'authorization_code',
    'client_id' => $config['client_id'],
    'redirect_uri' => $config['redirect_uri'],
    'code' => $code,
    'code_verifier' => ''
]));
curl_setopt($ch, CURLOPT_USERPWD, $config['client_id'] . ":" . $config['client_secret']);
$response = json_decode(curl_exec($ch), true);
curl_close($ch);

if (!isset($response['access_token'])) {
    die("Failed to authenticate");
}

$_SESSION['access_token'] = $response['access_token'];
header("Location: importer.php");
exit;