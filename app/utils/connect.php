<?php

define("ROOT", __DIR__ . '/../../' );

require_once ( ROOT . "app/config/database.php" );

$conn = new mysqli($serverName, $userName, $password, $baseName);

if ($conn->connect_error){
    die('Connection unsuccessful ERROR: ' . $conn->connect_error);
}