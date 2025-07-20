<?php
$config = require __DIR__ . '/../config/config.php';

$state = bin2hex(random_bytes(8));
$_SESSION['oauth_state'] = $state;

$auth_url = "https://www.etsy.com/oauth/connect?" . http_build_query([
    'response_type' => 'code',
    'redirect_uri' => $config['redirect_uri'],
    'scope' => 'listings_r listings_w',
    'client_id' => $config['client_id'],
    'state' => $state,
]);

header("Location: $auth_url");
exit;