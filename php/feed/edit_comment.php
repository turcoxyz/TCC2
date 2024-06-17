<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/home.html');
    exit();
}

$user_id = $_SESSION['user_id'];
$comment_id = $_GET['comment_id'];

// Verificar se o usuário tem permissão para editar o comentário
$stmt = $conexao->prepare("SELECT user_id, comment FROM comments WHERE id = ?");
$stmt->bind_param("i", $comment_id);
$stmt->execute();
$result = $stmt->get_result();
$comment = $result->fetch_assoc();

if ($comment['user_id'] !== $user_id) {
    echo "Você não tem permissão para editar este comentário.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment_text = $_POST['comment'];

    $stmt = $conexao->prepare("UPDATE comments SET comment = ? WHERE id = ?");
    $stmt->bind_param("si", $comment_text, $comment_id);
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
    <title>Editar Comentário</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Editar Comentário</h1>
        <form action="edit_comment.php?comment_id=<?php echo $comment_id; ?>" method="post">
            <div class="mb-3">
                <label for="comment" class="form-label">Comentário</label>
                <textarea class="form-control" id="comment" name="comment" rows="3" required><?php echo htmlspecialchars($comment['comment']); ?></textarea>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</body>
</html>
