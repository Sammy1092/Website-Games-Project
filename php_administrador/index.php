<?php
    session_start();
/************ BANCO DE DADOS ************/
    $servername  = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'empresa';

    $conn = mysqli_connect($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    

