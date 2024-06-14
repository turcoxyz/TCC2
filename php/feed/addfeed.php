<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $titulo = $_POST["titulo"];
    $conteudo = $_POST["conteudo"];

    // Conectar ao banco de dados (substitua pelas suas credenciais)
    $conexao = new mysqli("localhost", "root", "root", "cadastros");
    if ($conexao->connect_error) {
        die("Erro de conexão: " . $conexao->connect_error);
    }

    // Preparar e executar a consulta SQL para inserir a publicação
    $stmt = $conexao->prepare("INSERT INTO publicacoes (titulo, conteudo) VALUES (?, ?)");
    $stmt->bind_param("ss", $titulo, $conteudo);
    if ($stmt->execute()) {
        echo "Publicação adicionada com sucesso.";
    } else {
        echo "Erro ao adicionar publicação: " . $conexao->error;
    }

    // Fechar a declaração e a conexão
    $stmt->close();
    $conexao->close();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Adicionar Publicação</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Adicionar Publicação</h1>
    <form action="addfeed.php" method="POST">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required>
        <label for="conteudo">Conteúdo:</label>
        <textarea id="conteudo" name="conteudo" rows="4" required></textarea>
        <button type="submit">Adicionar</button>
    </form>
</div>
</body>
</html>
