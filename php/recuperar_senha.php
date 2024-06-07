<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $token = $_POST['token'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Atualiza a senha no banco de dados
    $stmt = $conexao->prepare("UPDATE usuarios SET senha=?, reset_token=NULL WHERE reset_token=?");
    $stmt->bind_param("ss", $password, $token);
    if ($stmt->execute()) {
        echo "Senha redefinida com sucesso!";
    } else {
        echo "Erro ao redefinir a senha.";
    }
    $stmt->close();
    $conexao->close();
} else if (isset($_GET['token'])) {
    $token = $_GET['token'];
} else {
    echo "Token inválido.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nova Senha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Nova Senha</h2>
        <form method="POST" action="nova_senha.php">
            <input type="hidden" name="token" value="<?php echo htmlspecialchars($token); ?>">
            <div class="mb-3">
                <label for="password" class="form-label">Nova Senha</label>
                <input type="password" class="form-control" id="password" name="password" required>
            </div>
            <button type="submit" class="btn btn-primary">Redefinir Senha</button>
        </form>
    </div>
</body>
</html>