<?php
    require_once 'vendor/autoload.php';
    $redirect_uri = 'http://' . $_SERVER['HTTP_HOST'] . '/drive/paso2.php';
    $client = new Google_Client();
    $client->setAuthConfig('credenciales.json');
    $client->setRedirectUri($redirect_uri);
    $client->addScope("https://www.googleapis.com/auth/drive");