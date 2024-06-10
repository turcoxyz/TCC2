<?php
session_start();
include_once('config.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $token = $_POST['token'];
    $new_password = password_hash($_POST['new_password'], PASSWORD_DEFAULT);

    $sql = "SELECT email FROM usuarios WHERE reset_token = ?";
    $stmt = $conexao->prepare($sql);
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        $email = $user['email'];

        $sql = "UPDATE usuarios SET senha = ?, reset_token = NULL WHERE email = ?";
        $stmt = $conexao->prepare($sql);
        $stmt->bind_param("ss", $new_password, $email);
        $stmt->execute();

        echo "Your password has been reset.";
    } else {
        echo "Invalid or expired token.";
    }

    $stmt->close();
}

$conexao->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resetar Senha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Resetar Senha</h2>
        <form action="reset_senha.php" method="POST">
            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
            <div class="form-group">
                <label for="new_password">Nova Senha:</label>
                <input type="password" name="new_password" class="form-control" required>
            </div>
            <br>
            <button type="submit" class="btn btn-primary">Resetar Senha</button>
        </form>
    </div>
</body>
</html>
