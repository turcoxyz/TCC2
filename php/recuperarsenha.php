<!doctype html>
<html lang="pt-BR" data-bs-theme="auto">

<head>
    <link rel="stylesheet" href="../css/cadastro.css">
<style>


/* Estilo do formulário de redefinição de senha */
.forma {
    margin: 20px auto;
    padding: 20px;
    max-width: 400px;
    border-radius: 5px;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
}

form label {
    display: block;
    margin-bottom: 10px;
    font-weight: bold;
}

form input[type="email"] {
    width: 100%;
    padding: 10px;
    margin-bottom: 20px;
    border: 1px solid #ced4da;
    border-radius: 5px;
}

.form-buttao {
    width: 100%;
    padding: 10px;
    background-color: #007bff;
    border: none;
    border-radius: 5px;
    color: #ffffff;
    font-weight: bold;
    cursor: pointer;
}

form button:hover {
    background-color: #0056b3;
}
</style>
    <script src="../assets/js/color-modes.js"></script>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    <title>ZooPet</title>
    <link rel="icon" href="../img/ZooPet Icone 2.png">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/blog/">
    <link rel="stylesheet" href="../pages/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/nightmode.css">
    <style>.enviar {
  background-color: #49745f;
  border: none;
  padding: 15px;
  width: 100%;
  border-radius: 10px;
  color: white;
  font-size: 15px;
}</style>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light navfundo justify-content-between">
        <div class="container">
            <div class="">
                <a class="navbar-brand" href="home.html">
                    <img class="logo" src="../img/ZooPet Logomarca.png" alt="">ZooPet
                </a>
            </div>
            <div class="botoes">
                <form class="d-inline">
                    <a href="../php/login.php">
                        <button class="btn btn-light m-70%" type="button">Entrar</button>
                    </a>
                    <a href="../php/registro.php">
                        <button class="btn btn-outline-light" type="button">Registrar</button>
                    </a>
                </form>
                <li class="nav dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" id="settingsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                            <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                            <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
                        </svg>
                        Configurações
                    </a>
                    <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="settingsDropdown">
                        <a class="dropdown-item" href="../pages/Integrantes/index.html">Quem Somos?</a>
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="chk">
                            <label class="form-check-label" for="chk">Modo Noturno</label>
                        </div>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="../pages/suporte.html">FAQ</a>
                    </div>
                </li>
            </div>
        </div>
    </nav>
<!-- FIM NAV BAR-->

<br>
<br>
<a href="../php/login.php"><button class="btn-voltar">&hookleftarrow; Voltar</button></a>
<br>
    <div class="container">
        <div class="reset-password-box">
            <h2>Redefinição de Senha</h2>
            <p>Por favor, insira seu endereço de e-mail registrado abaixo para redefinir sua senha. Enviaremos um link para você criar uma nova senha.</p>
            <form action="/send-reset-link" method="POST">
                <label for="email">E-mail registrado:</label>
                <input type="email" id="email" name="email" required>
                <button type="submit" class="enviar">Enviar link de redefinição de senha</button>
            </form>
            <br><br>
            <p class="support">Se precisar de assistência, entre em contato conosco em <a href="mailto:gustavopl.contato@gmail.com">gustavopl.contato@gmail.com</a></p>
        </div>
    </div>
</body>
<script src="../pages/feed.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="../js/nightmode.js"></script>
</html>