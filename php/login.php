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
        <a class="navbar-brand" href="../pages/home.html"><img class="logo" src="/img/ZooPet Logomarca.png" alt="">ZooPet</a>
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
    <br>
    <a href="home.php"><button class="btn-voltar">&hookleftarrow; Voltar</button></a>
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
</body>
</html>

