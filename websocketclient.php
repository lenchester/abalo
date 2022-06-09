<?php
/**
 * /websocketclient.php
 * Installieren in das Laravel-Wurzelverzeichnis.
 *
 * composer.json +Abhängigkeit: ratchet/pawl
 * Quelle des Beispiels: https://github.com/ratchetphp/Pawl (Letzter Zugriff 8.3.2022)
 */
require __DIR__ . '/vendor/autoload.php';

\Ratchet\Client\connect('ws://localhost:8085/chat')->then(function($conn) {
    /* $conn->on('message', function($msg) use ($conn) {
        echo "Received: {$msg}\n";
        $conn->close();
    }); */
    $conn->send('Hello to everyone!');
    $conn->close();
}, function ($e) {
    echo "Could not connect: {$e->getMessage()}\n";
});

