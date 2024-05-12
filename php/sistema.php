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
    <script src="/assets/js/color-modes.js"></script>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
<meta name="generator" content="Hugo 0.118.2">
<title>ZooPet</title>
<link rel="icon" href="/img/ZooPet Icone 2.png">

<link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/blog/">
<link rel="stylesheet" href="/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" href="/cadastro.css">
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light navfundo justify-content-between">
        <div class="container">
            <a class="navbar-brand" href="home.html"><img class="logo" src="/img/ZooPet Logomarca.png" alt="">ZooPet</a>


            <form class="form-inline">
                <a href="sair.php"><button class="btn btn-light" type="button">Sair</button></a>
            
            </form>

        </div>
    </nav>

    <?php
    echo "<h1>Bem vindo <u>$logado</u><h1>";
    ?>
</body>
</html>