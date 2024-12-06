<?php
    session_start();
/************ BANCO DE DADOS ************/
    $servername  = 'localhost';
    $username = 'root';
    $password = '';
    $database = 'empresa';
    $databaseGameShop = 'gameshop';

    $conn = mysqli_connect($servername, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if(!mysqli_select_db($conn,$databaseGameShop)){
        die("Falha ao selecionar o banco de dados 'gameshop': ". mysqli_error($conn));
    }

    

