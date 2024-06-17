<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/home.html');
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = $_GET['post_id'];

// Verificar se o usuário tem permissão para editar a publicação
$stmt = $conexao->prepare("SELECT user_id, title, content FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if ($post['user_id'] !== $user_id) {
    echo "Você não tem permissão para editar esta publicação.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['title'], $_POST['content'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $stmt = $conexao->prepare("UPDATE posts SET title = ?, content = ? WHERE id = ?");
    $stmt->bind_param("ssi", $title, $content, $post_id);
    $stmt->execute();
    $stmt->close();

    header('Location: feed.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Publicação</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Editar Publicação</h1>
        <form action="edit_post.php?post_id=<?php echo $post_id; ?>" method="post">
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Conteúdo</label>
                <textarea class="form-control" id="content" name="content" rows="3" required><?php echo htmlspecialchars($post['content']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</body>
</html>
