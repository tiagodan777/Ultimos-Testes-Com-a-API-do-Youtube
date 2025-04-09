<?php
require_once 'vendor/autoload.php';

session_start();

if (!isset($_SESSION['access_token'])) {
    die('Erro! Precisas estar autenticado: <a href="login.php">Log in</a>');
}

$client = new Google\Client();
$client->setAccessToken($_SESSION['access_token']);

if ($client->isAccessTokenExpired()) {
    echo "Token expirado. Precisas de fazer Log in de novo";
    session_destroy();
    exit;
}

$youtube = new Google\Service\YouTube($client);

$snippet = new Google\Service\YouTube\VideoSnippet();
$snippet->setTitle('Título de Exemplo 1');
$snippet->setDescription('Descrição de Exmplo para Teste 1');
$snippet->setTags(['testes', 'youtube']);

$status = new Google\Service\YouTube\VideoStatus();
$status->privacyStatus = 'public';

$video = new Google\Service\YouTube\Video();
$video->setSnippet($snippet);
$video->setStatus($status);

$client->setDefer(true);

$request = $youtube->videos->insert('status,snippet', $video);

$media = new Google\Http\MediaFileUpload(
    $client,
    $request,
    'video/*',
    null,
    true,
    1024 * 1024 * 2
);

$path = 'video-4.mp4';
$media->setFileSize(filesize($path));

$handle = fopen($path, 'rb');
$status = false;

while (!$status && !feof($handle)) {
    $chunk = fread($handle, 1024 * 1024 * 2);
    $status = $media->nextChunk($chunk);
}

fclose($handle);

$client->setDefer(false);

echo "Vídeo Enviado com Sucesso!";