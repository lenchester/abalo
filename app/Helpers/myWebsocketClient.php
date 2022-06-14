<?php

namespace App\Helpers;

class myWebsocketClient
{
    public function sendMessage($msg){
        \Ratchet\Client\connect('ws://localhost:8085/chat')->then(function($conn) use ($msg) {
            $conn->send($msg);
            $conn->close();
        }, function ($e) {
            echo "Could not connect: {$e->getMessage()}\n";
        });
    }
}
