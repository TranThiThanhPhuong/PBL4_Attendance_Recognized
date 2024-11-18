<?php
    $server = 'localhost';
    $user = 'root';
    $pass = '';
    $database = 'pbl4_mvc_02';

    $connectionDB = new mysqli($server, $user, $pass, $database);

    if ($connectionDB->connect_error) {
        die("Kết nối thất bại: " . $connectionDB->connect_error);
    } else {
        $connectionDB->set_charset("utf8");
    }
    
?>