<?php
if (isset($_POST['submit'])) {
    include_once('config.php');

    $nome = $_POST['Nome'];
    $nomeUser = $_POST['nomeUser'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $sexo = $_POST['genero'];
    $dt_nascimento = $_POST['data_nascimento'];
    $nm_bairro = $_POST['bairro'];
    $endereco = $_POST['nm_rua'];

    // Verificação de confirmação de senha
    if ($password !== $confirm_password) {
        echo "As senhas não coincidem.";
        exit();
    }

    // Validação do formato do email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "Formato de email inválido.";
        exit();
    }

    // Validação do tamanho da senha
    if (strlen($password) < 8) {
        echo "A senha deve ter pelo menos 8 caracteres.";
        exit();
    }

    // Hash da senha
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Converter o valor de sexo para sexo_id
    $sexo_id = null;
    $sexo_map = [
        'masculino' => 1,
        'feminino' => 2,
        'outros' => 3
    ];
    if (array_key_exists($sexo, $sexo_map)) {
        $sexo_id = $sexo_map[$sexo];
    } else {
        echo "Gênero inválido.";
        exit();
    }

    // Prepara a consulta
    $stmt = $conexao->prepare("INSERT INTO usuarios (nm_complete, nm_user, email, telefone, senha, sexo_id, dt_nascimento, nm_bairro, endereco) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssssssss", $nome, $nomeUser, $email, $telefone, $hashed_password, $sexo_id, $dt_nascimento, $nm_bairro, $endereco);

    // Executa a consulta
    if ($stmt->execute()) {
        header('Location: login.php');
        exit();
    } else {
        echo "Erro: " . $stmt->error;
    }

    // Fecha a declaração
    $stmt->close();
    // Fecha a conexão
    $conexao->close();
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
    <link rel="icon" href="../img/ZooPet Icone 2.png">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/blog/">
    <link rel="stylesheet" href="../pages/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/cadastro.css">
    <link rel="stylesheet" href="../css/nightmode.css">
    
    <script>
        function validatePassword() {
            var password = document.getElementsByName('password')[0].value;
            var confirm_password = document.getElementsByName('confirm_password')[0].value;
            if (password !== confirm_password) {
                alert("As senhas não coincidem.");
                return false;
            }
            return true;
        }
    </script>
</head>
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
    <a href="../pages/home.html"><button class="btn-voltar">&hookleftarrow; Voltar</button></a>
    <br><br><br>
    <div class="box">
        <form action="registro.php" method="POST" onsubmit="return validatePassword()">
            <legend><b>Cadastro de Usuario</b></legend>
            <br><br>
            <div class="inputbox">
                <input type="text" name="Nome" class="InputUser" required>
                <label for="Nome" class="labelInput">Nome Completo</label>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="text" name="nomeUser" class="InputUser" required>
                <label for="nomeUser" class="labelInput">Nome de Usuario</label>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="email" name="email" class="InputUser" required>
                <label for="email" class="labelInput">Email</label>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="tel" name="telefone" class="InputUser" required pattern="[0-9]{2}[0-9]{5}[0-9]{4}" title="Digite um telefone válido com 11 dígitos">
                <label for="telefone" class="labelInput">(DDD)Telefone</label>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="password" name="password" class="InputUser" required minlength="8">
                <label for="password" class="labelInput">Crie uma Senha</label>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="password" name="confirm_password" class="InputUser" required minlength="8">
                <label for="confirm_password" class="labelInput">Confirme a Senha</label>
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
            <br><br>
            <div class="inputbox">
                <label for="data_nascimento"><b>Data de Nascimento</b></label>
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
                <label for="nm_rua" class="labelInput">Endereço com Número</label>
            </div>
            <br><br>
            <input type="submit" name="submit" id="submit">
        </form>
    </div>
    
</body>
<script src="../pages/feed.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="../js/nightmode.js"></script>
</html>
