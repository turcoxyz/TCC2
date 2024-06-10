<?php
// Recupera o ID da imagem da URL
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    include 'config.php';

    // Busca a imagem na tabela imagens
    $stmt = $conexao->prepare("SELECT tipo, dados FROM imagens WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($tipo, $dados);

    if ($stmt->fetch()) {
        // Define o cabeçalho Content-type baseado no tipo da imagem
        header("Content-type: $tipo");
        echo $dados;
    }

    $stmt->close();
    $conexao->close();
}
?>