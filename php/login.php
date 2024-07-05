<?php
session_start();
include_once('config.php');

$error_message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    $sql = "SELECT id, nm_user, nm_complete, senha FROM usuarios WHERE email = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        
        if (password_verify($senha, $user['senha'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['nm_user'] = $user['nm_user'];
            $_SESSION['nm_complete'] = $user['nm_complete'];
            $_SESSION['email'] = $email;

            header("Location: home.php");
            exit();
        } else {
            $error_message = "Email ou senha incorretos!";
        }
    } else {
        $error_message = "Email ou senha incorretos!";
    }

    $stmt->close();
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <script src="../assets/js/color-modes.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - ZooPet</title>
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/blog/">
  <link rel="stylesheet" href="../pages/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/nightmode.css">
<link rel="stylesheet" href="../css/cadastro.css">
    <script>
        function togglePasswordVisibility() {
            var passwordField = document.getElementById("senha");
            if (passwordField.type === "password") {
                passwordField.type = "text";
            } else {
                passwordField.type = "password";
            }
        }
    </script>
</head>
<!--NAVBAR--> 
<nav class="navbar navbar-expand-lg navbar-light navfundo justify-content-between">
        <div class="container">
            <a class="navbar-brand" href="../pages/home.html"><img class="logo" src="../img/ZooPet Logomarca.png"
                    alt="">ZooPet</a>

            <div class="botoes">
                <form class="d-inline">
                    <a href="../php/login.php"><button class="btn btn-light m-70%" type="button">Entrar</button></a>
                    <a href="../php/registro.php"><button class="btn btn-outline-light"
                            type="button">Registrar</button></a>
                        </form>
                        <!-- Dropdown menu -->
            <li class="nav dropdown">
                <a class="nav-link dropdown-toggle text-white" href="#" id="settingsDropdown" role="button"
                    data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                        class="bi bi-gear" viewBox="0 0 16 16">
                        <path
                            d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                        <path
                            d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
                    </svg>
                    Configurações
                </a>
                <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="settingsDropdown">
                    <a class="dropdown-item" href="../pages/Integrantes/index.html">Quem Somos?</a>
                    <div class="dropdown-item">
                        <div class="form-check form-switch">
                            <input class="form-check-input" type="checkbox" id="chk">
                            <label class="form-check-label" for="chk">Modo Noturno</label>
                        </div>
                    </div>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="../pages/suporte.html">FAQ</a>
                </div>
            </li>

            </div>
            
            

        </div>
    </nav>
<body>
    <br>
    <a href="../php/home.php"><button class="btn-voltar">&hookleftarrow; Voltar</button></a>
    <div id="form" style="width: 500px;">
        <h1>Login</h1>
        
        <form action="login.php" method="POST">
            <input type="text" name="email" placeholder="Email" class="InputUser" required>
            <br><br>
            <input type="password" name="senha" id="senha" placeholder="Senha" class="InputUser" required>
            <br><br>
            <input type="checkbox" onclick="togglePasswordVisibility()"> Mostrar senha
            <br><br>
            <?php if ($error_message): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error_message; ?>
                </div>
            <?php endif; ?>
            <input type="submit" name="submit" value="Entrar" class="enviar">
            <br><br>
            <form class="form-inline">
                <a href="recuperarsenha.php"><button class="btn btn-light" type="button">Esqueceu sua senha?</button></a>
            </form>
        </form>
    </div>
    <script src="../java.js"></script>
        <script src="../js/java.js"></script>
        <link rel="stylesheet" href="../css/nightmode.css">
</body>
<script src="../pages/feed.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="../js/nightmode.js"></script>
</html>

