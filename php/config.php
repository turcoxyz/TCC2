<?php

$dbHost = 'localhost';
$dbUsername = 'root';
$dbPassword = 'root';
$dbName = 'cadastros';

$conexao = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName);

//if ($conexao->connect_errno) {
    //printf("Erro de conexão: %s\n", $conexao->connect_error);
    //exit();
//} else {
    //echo "Conexão estabelecida com sucesso!\n";
    // Perform some queries or operations on the database here
    //$conexao->close();
//}

?>