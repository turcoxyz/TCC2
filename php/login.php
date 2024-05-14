
<!DOCTYPE html>
<html lang="en">
<head>
<script src="/assets/js/color-modes.js"></script>


    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ZooPet</title>
    

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
<a href="home.php"><button class="btn-voltar">&hookleftarrow; Voltar</button></a>
<div id="form" style="width: 500px;">
        <h1>Login</h1>
        <form action="teste.php" method="POST">
        <input type="text" name="email" placeholder="email" class="InputUser">
        <br><br>
        <input type="password" name="senha" placeholder="Senha" class="InputUser">
        <br><br>
        <input type="submit" name="submit" value="Enviar" class="enviar">
<br><br>
        <input type="button" value="Esqueceu sua senha? Clique aqui!" class="forget">
    </div>
</form>
</body>
</html>