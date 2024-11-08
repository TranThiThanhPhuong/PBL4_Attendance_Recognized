<?php
    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $database = 'databasepbl4';

    $connectionDB = new mysqli($server, $user, $pass, $database);

    if ($connectionDB->connect_error) {
        die("Kết nối thất bại: " . $connectionDB->connect_error);
    } else {
        $connectionDB->set_charset("utf8");
    }
    
?>