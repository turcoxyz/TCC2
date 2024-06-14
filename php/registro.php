<?php
session_start();
include 'config.php';

if (!isset($_SESSION['email']) || !isset($_SESSION['senha'])) {
  unset($_SESSION['email']);
  unset($_SESSION['senha']);
  header('Location: ../pages/home.html');
  exit();
}

$user_id = $_SESSION['user_id']; // assumindo que você armazena user_id na sessão

$sql = "SELECT nm_user FROM usuarios WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
  $user = $result->fetch_assoc();
  $user_name = htmlspecialchars($user['nm_user']); // Sanitização para evitar XSS
} else {
  $user_name = "Usuário";
}

$stmt->close();
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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/pages/cadastro.css">
    <script>
        function validateForm() {
            var isValid = true;
            var errors = {};

            var password = document.getElementsByName('password')[0].value;
            var confirm_password = document.getElementsByName('confirm_password')[0].value;
            if (password !== confirm_password) {
                errors['confirm_password'] = "As senhas não coincidem.";
                isValid = false;
            }

            var email = document.getElementsByName('email')[0].value;
            var emailPattern = /^[a-zA-Z0-9._-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6}$/;
            if (!emailPattern.test(email)) {
                errors['email'] = "Formato de email inválido.";
                isValid = false;
            }

            var telefone = document.getElementsByName('telefone')[0].value;
            var telefonePattern = /^[0-9]{2}[0-9]{5}[0-9]{4}$/;
            if (!telefonePattern.test(telefone)) {
                errors['telefone'] = "Digite um telefone válido com 11 dígitos.";
                isValid = false;
            }

            if (password.length < 8) {
                errors['password'] = "A senha deve ter pelo menos 8 caracteres.";
                isValid = false;
            }

            // Clear previous error messages
            document.querySelectorAll('.error').forEach(el => el.textContent = '');

            // Display error messages
            for (var key in errors) {
                var errorElement = document.getElementById(key + '_error');
                if (errorElement) {
                    errorElement.textContent = errors[key];
                }
            }

            return isValid;
        }
    </script>
    <style>
        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>

<body>
    <br>
    <a href="home.php"><button class="btn-voltar">&hookleftarrow; Voltar</button></a>
    <br><br><br>
    <div class="box">
        <form action="registro.php" method="POST" onsubmit="return validateForm()">
            <legend><b>Cadastro de Usuario</b></legend>
            <br><br>
            <div class="inputbox">
                <input type="text" name="Nome" class="InputUser" required>
                <label for="Nome" class="labelInput">Nome Completo</label>
                <div id="Nome_error" class="error"></div>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="text" name="nomeUser" class="InputUser" required>
                <label for="nomeUser" class="labelInput">Nome de Usuario</label>
                <div id="nomeUser_error" class="error"></div>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="email" name="email" class="InputUser" required>
                <label for="email" class="labelInput">Email</label>
                <div id="email_error" class="error"></div>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="tel" name="telefone" class="InputUser" required pattern="[0-9]{2}[0-9]{5}[0-9]{4}" title="Digite um telefone válido com 11 dígitos">
                <label for="telefone" class="labelInput">(DDD)Telefone</label>
                <div id="telefone_error" class="error"></div>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="password" name="password" class="InputUser" required minlength="8">
                <label for="password" class="labelInput">Crie uma Senha</label>
                <div id="password_error" class="error"></div>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="password" name="confirm_password" class="InputUser" required minlength="8">
                <label for="confirm_password" class="labelInput">Confirme a Senha</label>
                <div id="confirm_password_error" class="error"></div>
            </div>
            <br><br>
            <p>Gênero</p>
            <input type="radio" name="genero" id="masculino" value="masculino" required>
            <label for="masculino">Masculino</label>
            <br>
            <input type="radio" name="genero" id="feminino" value="feminino" required>
            <label for="feminino">Feminino</label>
            <br>
            <input type="radio" name="genero" id="outros" value="outros" required>
            <label for="outros">Outros</label>
            <div id="genero_error" class="error"></div>
            <br><br>
            <div class="inputbox">
                <label for="data_nascimento"><b>Data de Nascimento</b></label>
                <input type="date" name="data_nascimento" id="data_nascimento" required>
                <div id="data_nascimento_error" class="error"></div>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="text" name="bairro" class="InputUser" required>
                <label for="bairro" class="labelInput">Nome do Bairro</label>
                <div id="bairro_error" class="error"></div>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="text" name="nm_rua" class="InputUser" required>
                <label for="nm_rua" class="labelInput">Endereço com Número</label>
                <div id="nm_rua_error" class="error"></div>
            </div>
            <br><br>
            <input type="submit" name="submit" id="submit">
            <?php
            if (!empty($errors)) {
                echo '<div class="error">Erros encontrados:<br>';
                foreach ($errors as $error) {
                    echo $error . '<br>';
                }
                echo '</div>';
            }
            ?>
        </form>
    </div>
</body>
</html>
