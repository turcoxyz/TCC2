<?php

if(isset($_POST['submit']))
{
include_once('config.php');

$nome =$_POST['Nome'];
$nomeUser = $_POST['nomeUser'];
$email = $_POST['email'];
$telefone = $_POST['telefone'];
$password = $_POST['password'];
$sexo = $_POST['genero'];
$dt_nascimento = $_POST['data_nascimento'];
$nm_bairro = $_POST['bairro'];
$endereço = $_POST['nm_rua'];

$result = mysqli_query($conexao, "INSERT INTO usuarios(nm_complete,nm_user,email,telefone,senha,sexo,dt_nascimento,nm_bairro,endereço) 
VALUES('$nome','$nomeUser','$email','$telefone','$password','$sexo','$dt_nascimento','$nm_bairro','$endereço')");

header('location: login.php');
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
<script src="/assets/js/color-modes.js"></script>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="description" content="">
<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
<meta name="generator" content="Hugo 0.118.2">
<title>ZooPet</title>
<link rel="icon" href="/img/ZooPet Icone 2.png">

<link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/blog/">
<link rel="stylesheet" href="/pages/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" href="/pages/cadastro.css">
</head>
<!--NAVBAR--> 

<nav class="navbar navbar-expand-lg navbar-light navfundo justify-content-between">
    <div class="container">
        <a class="navbar-brand" href="/index.html"><img class="logo" src="/img/ZooPet Logomarca.png" alt="">ZooPet</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
            aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <form class="form-inline">
            <a href="login.php"><button class="btn btn-light" type="button">Entrar</button></a>
            <a href="registro.php"><button class="btn btn-outline-light" type="button">Registrar</button></a>
        </form>

    </div>
</nav>
<body>
    

    <a href="home.php">VOLTAR</a>

<br><br><br>
    <!--TABELA DE CADASTRO--> 
    <div class="box">
        <form action="registro.php" method="POST">
            <legend><b>Cadastro de Usuario</b></legend>
            <br><br>
            <div class="inputbox">
                <input type="text" name="Nome" class="InputUser" required>
                <label for="Nome" class="labelInput">Nome Completo</label>
                <br><br>
                <div class="inputbox">
                    <input type="text" name="nomeUser" class="InputUser" required>
                    <label for="nomeUser" class="labelInput">Nome de Usuario</label>
                <br><br>
            </div>
            <div class="inputbox">
                <input type="text" name="email" class="InputUser" required>
                <label for="email" class="labelInput">Email</label>
            </div>
            <br>
            <div class="inputbox">

                <input type="tel" name="telefone" class="InputUser" required>
                <label for="telefone" class="labelInput">(DDD)Telefone</label>
                <br><br>
                <div class="inputbox">

                    <input type="password" name="password" class="InputUser" required>
                    <label for="password" class="labelInput">Crie uma Senha</label>
                    <br><br>
            <p>Gênero</p>
            <input type="radio" name="genero" id="masculino" value="masculino" required>
            <label for="masculino">Masculino</label>
            <br>
            <input type="radio" name="genero" id="feminino" value="feminino" required>
            <label for="Feminino">Feminino</label class="ajusteinput">
            <br>
            <input type="radio" name="genero" id="outros" value="outros" required>
            <label for="outros">Outros</label>
            <br>
            <br>
            <div class="inputbox">
                <label for="data_nascimento"><b>Data de Nascimento</b></label class="ajusteinput">
                <input type="date" name="data_nascimento" id="data_nascimento" required>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="text" name="bairro" class="InputUser" required>
                <label for="bairro" class="labelInput">Nome do Bairro</label>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="text" name="nm_rua" class="InputUser" required>
                <label for="nm_rua" class="labelInput">Endereço com Número </label>
            </div>
            <br><br>
            <input type="submit" name="submit" id="submit">

        </form>
    </div>
</body>

</html>