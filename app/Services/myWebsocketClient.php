<?php

namespace App\Services;

class myWebsocketClient
{
    public function sendMessage(){
        \Ratchet\Client\connect('ws://localhost:8085/chat')->then(function($conn) {
            /* $conn->on('message', function($msg) use ($conn) {
                echo "Received: {$msg}\n";
                $conn->close();
            }); */
            $conn->send('
In Kürze verbessern wir Abalo für Sie! Nach einer kurzen Pause sind wir wieder für Sie da! Versprochen.');
            $conn->close();
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });
    }
}
