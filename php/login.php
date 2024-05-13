
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
<link rel="stylesheet" href="/style.css">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" href="/cadastro.css">
</head>
<body>

<!--NAVBAR--> 

<nav class="navbar navbar-expand-lg navbar-light navfundo justify-content-between">
        <div class="container">
            <a class="navbar-brand" href="/index.html"><img class="logo" src="/img/ZooPet Logomarca.png" alt="">ZooPet</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarScroll"
                aria-controls="navbarScroll" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <form class="form-inline">
                <button class="btn btn-light" type="button"><a href="#" style="text-decoration: none; color: black;">Entrar</a></button>
                <button class="btn btn-outline-light" type="button"><a href="registro.php"  style="text-decoration: none; color: inherit !important;">Registrar</a></button>
            </form>

            <!-- <div class="collapse navbar-collapse" id="navbarScroll">
                <ul class="listaTP navbar-nav me-auto my-2 my-lg-0 navbar-nav-scroll ">
                    <li class="nav-item">
                        <a class="nav-link active" aria-current="page" href="home.html">Home</a>
                    </li>

                    <li class="nav-item">
                        <a class="nav-link active" href="Suporte.html" tabindex="-1" aria-disabled="true">Suporte</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="intergrantes.html">Integrantes</a></a>
                    </li>
                </ul>

            </div> -->


        </div>
    </nav>

<a href="home.php">VOLTAR</a>

    
    <div id="form">
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