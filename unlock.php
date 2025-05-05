<?php
$ip = "192.168.99.254";
$port = 8728;
$username = "admin";
$password = "Geulech@1234";

require('routeros_api.class.php');
$API = new RouterosAPI();

if ($API->connect($ip, $username, $password, $port)) {
    
    $API->comm("/ip/hotspot/ip-binding/add", [
        "address" => "0.0.0.0/0",
        "type" => "bypassed",
        "comment" => "WhatsApp temporaire"
    ]);

    $API->comm("/system/script/add", [
        "name" => "remove-whatsapp-access",
        "source" => "/ip hotspot ip-binding remove [find comment=\"WhatsApp temporaire\"]"
    ]);

    $API->comm("/system/scheduler/add", [
        "name" => "timeout-whatsapp",
        "start-time" => "+00:03:00",
        "on-event" => "remove-whatsapp-access"
    ]);

    echo "✅ Accès WhatsApp débloqué pendant 3 minutes.";
    $API->disconnect();
} else {
    echo "❌ Connexion au MikroTik échouée.";
}
?>
