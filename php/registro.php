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
    <link rel="icon" href="/img/ZooPet Icone 2.png">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/blog/">
    <link rel="stylesheet" href="/pages/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="/pages/cadastro.css">
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

<body>
    <br>
    <a href="home.php"><button class="btn-voltar">&hookleftarrow; Voltar</button></a>
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
</html>
