<?php
function etsy_get_listings($access_token, $shop_id) {
    $url = "https://openapi.etsy.com/v3/application/shops/$shop_id/listings/active?limit=100";
    $headers = [
        "Authorization: Bearer $access_token",
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true)['results'] ?? [];
}

function etsy_update_listing($access_token, $listing_id, $data) {
    $url = "https://openapi.etsy.com/v3/application/listings/$listing_id";
    $headers = [
        "Authorization: Bearer $access_token",
        "Content-Type: application/json"
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}