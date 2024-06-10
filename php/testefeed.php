<?php
// Conectar ao banco de dados (substitua pelas suas credenciais)
$conexao = new mysqli("localhost", "root", "root", "cadastros");
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

// Consulta SQL para obter as publicações
$resultado = $conexao->query("SELECT * FROM publicacoes ORDER BY data_publicacao DESC");

// Exibir as publicações
while ($row = $resultado->fetch_assoc()) {
    echo "<h2>" . $row["titulo"] . "</h2>";
    echo "<p>" . $row["conteudo"] . "</p>";
    echo "<p>Publicado em: " . $row["data_publicacao"] . "</p>";
    echo "<hr>";
}

// Fechar a conexão
$conexao->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Feed de Publicações</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
<div class="container">
    <h1>Feed de Publicações</h1>
    <?php
// Conectar ao banco de dados (substitua pelas suas credenciais)
$conexao = new mysqli("localhost", "usuario", "senha", "nome_do_banco");
if ($conexao->connect_error) {
    die("Erro de conexão: " . $conexao->connect_error);
}

// Consulta SQL para obter as publicações e os usuários que as fizeram
$resultado = $conexao->query("SELECT p.*, u.nm_user FROM publicacoes p JOIN usuarios u ON p.usuario_id = u.id ORDER BY p.data_publicacao DESC");

// Exibir as publicações
while ($row = $resultado->fetch_assoc()) {
    echo "<h2>" . $row["titulo"] . "</h2>";
    echo "<p>" . $row["conteudo"] . "</p>";
    echo "<p>Publicado por: " . $row["nm_user"] . " em " . $row["data_publicacao"] . "</p>";
    echo "<hr>";
}

// Fechar a conexão
$conexao->close();
?>
</div>
</body>
</html>
