<?php
session_start();
include('config.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $token = bin2hex(random_bytes(50));
    $url = "http://localhost:3000/nova_senha.php?token=$token";

    // Atualiza o token no banco de dados
    $stmt = $conexao->prepare("UPDATE usuarios SET reset_token=? WHERE email=?");
    $stmt->bind_param("ss", $token, $email);
    if ($stmt->execute()) {
        // Envia o e-mail com o link de redefinição
        $to = $email;
        $subject = "Redefinição de Senha";
        $message = "Clique no link para redefinir sua senha: $url";
        $headers = "From: no-reply@seusite.com";
        mail($to, $subject, $message, $headers);
        echo "Um e-mail com as instruções foi enviado para $email.";
    } else {
        echo "Erro ao solicitar a redefinição de senha.";
    }
    $stmt->close();
    $conexao->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperar Senha</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h2>Recuperar Senha</h2>
        <form method="POST" action="recuperar_senha.php">
            <div class="mb-3">
                <label for="email" class="form-label">E-mail</label>
                <input type="email" class="form-control" id="email" name="email" required>
            </div>
            <button type="submit" class="btn btn-primary">Enviar</button>
        </form>
    </div>
</body>
</html>