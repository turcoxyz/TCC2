<?php
session_start();
include_once('config.php');

// Verifica se o usuário está logado
if (!isset($_SESSION['email'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['email'];

// Função para sanitizar a entrada do usuário
function sanitize_input($data) {
    return htmlspecialchars(strip_tags(trim($data)));
}

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['submit'])) {
    $nome = sanitize_input($_POST['nm_complete']);
    $nomeUser = sanitize_input($_POST['nm_user']);
    $email = sanitize_input($_POST['email']);
    $telefone = sanitize_input($_POST['telefone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $sexo = sanitize_input($_POST['genero']);
    $dt_nascimento = sanitize_input($_POST['dt_nascimento']);
    $nm_bairro = sanitize_input($_POST['nm_bairro']);
    $endereco = sanitize_input($_POST['endereço']);

    // Verifica se o campo de senha está preenchido
    if (!empty($password)) {
        if ($password !== $confirm_password) {
            echo "As senhas não coincidem.";
            exit();
        }
        $hashed_password = password_hash($password, PASSWORD_DEFAULT); // Criptografa a senha
        $stmt = $conexao->prepare("UPDATE usuarios SET nm_complete=?, nm_user=?, email=?, telefone=?, senha=?, sexo=?, dt_nascimento=?, nm_bairro=?, endereco=? WHERE id=?");
        $stmt->bind_param("sssssssssi", $nome, $nomeUser, $email, $telefone, $hashed_password, $sexo, $dt_nascimento, $nm_bairro, $endereco, $user_id);
    } else {
        $stmt = $conexao->prepare("UPDATE usuarios SET nm_complete=?, nm_user=?, email=?, telefone=?, sexo=?, dt_nascimento=?, nm_bairro=?, endereco=? WHERE id=?");
        $stmt->bind_param("ssssssssi", $nome, $nomeUser, $email, $telefone, $sexo, $dt_nascimento, $nm_bairro, $endereco, $user_id);
    }

    if ($stmt->execute()) {
        echo "Perfil atualizado com sucesso!";
    } else {
        echo "Erro: " . $stmt->error;
    }

    $stmt->close();
}

// Seleciona os dados antigos do usuário
$stmt = $conexao->prepare("SELECT nm_complete, nm_user, email, telefone, sexo, dt_nascimento, nm_bairro, endereço FROM usuarios WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nome, $nomeUser, $email, $telefone, $sexo, $dt_nascimento, $nm_bairro, $endereco);
$stmt->fetch();
$stmt->close();
$conexao->close();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Perfil</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <h2>Editar Perfil</h2>
        <form action="" method="POST">
            <div class="mb-3">
                <label for="Nome" class="form-label">Nome Completo</label>
                <input type="text" class="form-control" id="Nome" name="Nome" value="<?php echo htmlspecialchars($nome); ?>" required>
            </div>
            <div class="mb-3">
                <label for="nomeUser" class="form-label">Nome de Usuário</label>
                <input type="text" class="form-control" id="nomeUser" name="nomeUser" value="<?php echo htmlspecialchars($nomeUser); ?>" required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Email</label>
                <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required>
            </div>
            <div class="mb-3">
                <label for="telefone" class="form-label">Telefone</label>
                <input type="tel" class="form-control" id="telefone" name="telefone" value="<?php echo htmlspecialchars($telefone); ?>" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Nova Senha</label>
                <input type="password" class="form-control" id="password" name="password">
            </div>
            <div class="mb-3">
                <label for="confirm_password" class="form-label">Confirmar Nova Senha</label>
                <input type="password" class="form-control" id="confirm_password" name="confirm_password">
            </div>
            <div class="mb-3">
                <label for="genero" class="form-label">Gênero</label>
                <div>
                    <input type="radio" id="masculino" name="genero" value="masculino" <?php echo ($sexo == 'masculino') ? 'checked' : ''; ?> required>
                    <label for="masculino">Masculino</label>
                </div>
                <div>
                    <input type="radio" id="feminino" name="genero" value="feminino" <?php echo ($sexo == 'feminino') ? 'checked' : ''; ?> required>
                    <label for="feminino">Feminino</label>
                </div>
                <div>
                    <input type="radio" id="outros" name="genero" value="outros" <?php echo ($sexo == 'outros') ? 'checked' : ''; ?> required>
                    <label for="outros">Outros</label>
                </div>
            </div>
            <div class="mb-3">
                <label for="data_nascimento" class="form-label">Data de Nascimento</label>
                <input type="date" class="form-control" id="data_nascimento" name="data_nascimento" value="<?php echo htmlspecialchars($dt_nascimento); ?>" required>
            </div>
            <div class="mb-3">
                <label for="bairro" class="form-label">Bairro</label>
                <input type="text" class="form-control" id="bairro" name="bairro" value="<?php echo htmlspecialchars($nm_bairro); ?>" required>
            </div>
            <div class="mb-3">
                <label for="nm_rua" class="form-label">Endereço</label>
                <input type="text" class="form-control" id="nm_rua" name="nm_rua" value="<?php echo htmlspecialchars($endereco); ?>" required>
            </div>
            <button type="submit" name="submit" class="btn btn-primary">Atualizar Perfil</button>
        </form>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>