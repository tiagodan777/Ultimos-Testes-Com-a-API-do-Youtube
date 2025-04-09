<?php
require_once 'vendor/autoload.php';

$client = new Google\Client();

$client->setClientId('228677230345-m0apngdq5vpcbr0n6d4dv2ndklkditg1.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost:8888/Ultimos-Testes-Com-a-API-do-Youtube/callback.php');
$client->addScope('https://www.googleapis.com/auth/youtube.upload');

$authUrl = $client->createAuthUrl();

echo "<a href='$authUrl'>Log in com a Google</a>";