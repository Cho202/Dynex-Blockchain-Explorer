<?php
ini_set("session.gc_maxlifetime", 100*24*60*60);
ini_set("session.cache_expire", 100*24*60*60);
session_start();
$company_copyright = 'Dynex Platform';
//Daemon connect RPC endpoint:
$DAEMON_ENDPOINT = "http://localhost:18333/json_rpc";
$DAEMON_RAW_ENDPOINT = "http://localhost:18333";
?>



