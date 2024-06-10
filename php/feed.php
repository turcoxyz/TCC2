<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed de Publicações</title>
</head>

<body>

<?php
session_start();
include 'config.php';

// Verifica se o usuário está logado
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('location: ../pages/home.html');
}

$user_id = $_SESSION['user_id']; // assumindo que você armazena user_id na sessão

// Verifica se o formulário de adição de publicação foi enviado
if (isset($_POST['submit'])) {
    $titulo = $_POST['titulo'];
    $conteudo = $_POST['conteudo'];

    // Verifica se uma imagem foi enviada
    if (!empty($_FILES['imagem']['name'])) {
        $imagem_nome = $_FILES['imagem']['name'];
        $imagem_tipo = $_FILES['imagem']['type'];
        $imagem_tamanho = $_FILES['imagem']['size'];
        $imagem_dados = file_get_contents($_FILES['imagem']['tmp_name']);

        // Inserir imagem na tabela imagens
        $stmt_imagem = $conexao->prepare("INSERT INTO imagens (nome, tipo, tamanho, dados) VALUES (?, ?, ?, ?)");
        $stmt_imagem->bind_param("ssib", $imagem_nome, $imagem_tipo, $imagem_tamanho, $imagem_dados);
        $stmt_imagem->execute();
        $imagem_id = $stmt_imagem->insert_id;
        $stmt_imagem->close();
    } else {
        $imagem_id = null; // Definir imagem_id como null se nenhuma imagem for enviada
    }

    // Inserir publicação na tabela publicacoes
    $stmt_publicacao = $conexao->prepare("INSERT INTO publicacoes (user_id, titulo, conteudo, imagem_id) VALUES (?, ?, ?, ?)");
    $stmt_publicacao->bind_param("isss", $user_id, $titulo, $conteudo, $imagem_id);
    if ($stmt_publicacao->execute()) {
        echo "Publicação adicionada com sucesso.";
        // Redirecionar para o feed de publicações após o envio
        header('Location: feed.php');
        exit(); // Certifique-se de sair do script após o redirecionamento
    } else {
        echo "Erro ao adicionar publicação: " . $stmt_publicacao->error;
    }
    $stmt_publicacao->close();
}

$resultado = $conexao->query("SELECT p.*, i.nome as imagem_nome, i.tipo as imagem_tipo, i.tamanho as imagem_tamanho, u.nm_user
    FROM publicacoes p
    LEFT JOIN imagens i ON p.imagem_id = i.id
    INNER JOIN usuarios u ON p.user_id = u.id
    ORDER BY p.created_at DESC");

while ($row = $resultado->fetch_assoc()) {
    echo "<h2>" . $row["titulo"] . "</h2>";
    echo "<p>" . $row["conteudo"] . "</p>";
    echo "<p>Publicado por: " . $row["nm_user"] . "</p>";
    if ($row["imagem_nome"] != null) {
        // Exibe a imagem diretamente, se existir
        echo '<img src="caminho_para_suas_imagens/' . $row["imagem_nome"] . '"/>';
    }
    echo "<p>Publicado em: " . $row["created_at"] . "</p>";
    echo "<hr>";
}

$conexao->close();
?>





    <h1>Adicionar Publicação</h1>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="POST" enctype="multipart/form-data">
        <label for="titulo">Título:</label>
        <input type="text" id="titulo" name="titulo" required><br><br>
        <label for="conteudo">Conteúdo:</label><br>
        <textarea id="conteudo" name="conteudo" rows="4" required></textarea><br><br>
        <label for="imagem">Imagem:</label>
        <input type="file" id="imagem" name="imagem"><br><br>
        <input type="submit" name="submit" value="Adicionar">
    </form>

</body>

</html>