<?php
function sendMessage($target, $message, $extra = [])
{
    $payload = array_merge([
        "target" => $target,
        "message" => $message
    ], $extra);

    $curl = curl_init();

    curl_setopt_array($curl, [
        CURLOPT_URL => 'https://api.fonnte.com/send',
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $payload,
        CURLOPT_HTTPHEADER => ["Authorization: " . FONNTE_TOKEN],
    ]);

    $response = curl_exec($curl);
    curl_close($curl);

    return $response;
}
