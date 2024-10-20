#!/usr/bin/env php
<?php

use org\bovigo\vfs\vfsStream;

require __DIR__ . '/vendor/autoload.php';

$root = vfsStream::setup();

$config = require __DIR__ . '/config.php';

$server = 'https://127.0.0.1:6443';
$endpoint = '/api/v1/namespaces/default/pods';

// write ca data to a php stream wrapper to keep it in memory
$ca_file = $root->url() . '/ca.pem';
file_put_contents($ca_file, $config['ca_data']);

// write client cert data to a php stream wrapper to keep it in memory
$client_cert_file = $root->url() . '/client.crt';
file_put_contents($client_cert_file, $config['client_cert']);

// write client key data to a php stream wrapper to keep it in memory
$client_key_file = $root->url() . '/client.key';
file_put_contents($client_key_file, $config['client_key']);

// using curl, create a request to 
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $server . $endpoint);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_CAINFO, $ca_file);
curl_setopt($ch, CURLOPT_SSLCERT, $client_cert_file);
curl_setopt($ch, CURLOPT_SSLKEY, $client_key_file);

$response = curl_exec($ch);
if (curl_errno($ch)) {
    echo 'Error:' . curl_error($ch);
}
curl_close($ch);

echo $response;