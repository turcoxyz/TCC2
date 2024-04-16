<?php

$dbHost = 'Localhost';
$dbUsername = 'root';
$dbPassword = 'Kataff@1002';
$dbName = 'formulario'

$conexão = new mysqli($dbHost, $dbUsername, $dbPassword, $dbName)

if($conexão->connect_errno)
{
    echo "Erro";
}
else
{
    echo"conectado";
}
?>
