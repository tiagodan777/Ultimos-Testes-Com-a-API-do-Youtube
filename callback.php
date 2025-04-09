<?php
require_once 'vendor/autoload.php';

session_start();

$client = new Google\Client();
$client->setClientId('228677230345-m0apngdq5vpcbr0n6d4dv2ndklkditg1.apps.googleusercontent.com');
$client->setClientSecret('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');
$client->setRedirectUri('http://localhost:8888/Ultimos-Testes-Com-a-API-do-Youtube/callback.php');

if (isset($_GET['code'])) {
    $code = $_GET['code'];

    $token = $client->fetchAccessTokenWithAuthCode($code);

    if (isset($token['access_token'])) {
        $_SESSION['access_token'] = $token;

        echo "Autenticação bem sucedida! Token salvo na sessão.<br/>";
        echo "<a href='upload.php'>Enviar vídeo</a>";
    } else {
        echo "Erro ao obter token";
    }
} else {
    echo "Nenhum código recebido";
}