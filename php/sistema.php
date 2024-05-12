<?php
session_start();
if((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true))
{
    unset($_SESSION['email']);
  unset($_SESSION['senha']);
    header('location: login.php');
}
$logado = $_SESSION['email'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ZOOPET SISTEMA</title>
</head>
<body>
    <?php
    echo "<h1>Bem vindo <u>$logado</u><h1>";
    ?>
    <div class="sair">
        <a href="sair.php" class>SAIR</a>
    </div>
</body>
</html>