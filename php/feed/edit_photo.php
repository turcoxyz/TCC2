<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/home.html');
    exit();
}

$user_id = $_SESSION['user_id'];
$post_id = $_GET['post_id'];

// Verificar se o usuário tem permissão para editar a foto da publicação
$stmt = $conexao->prepare("SELECT user_id, image_path FROM posts WHERE id = ?");
$stmt->bind_param("i", $post_id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if ($post['user_id'] !== $user_id) {
    echo "Você não tem permissão para editar esta foto.";
    exit();
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($_FILES["image"]["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    if ($_FILES["image"]["size"] > 5000000) {
        echo "Desculpe, seu arquivo é muito grande.";
        exit();
    }

    if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
        echo "Desculpe, apenas arquivos JPG, JPEG, PNG & GIF são permitidos.";
        exit();
    }

    if (move_uploaded_file($_FILES["image"]["tmp_name"], $target_file)) {
        $image_path = $target_file;
        $stmt = $conexao->prepare("UPDATE posts SET image_path = ? WHERE id = ?");
        $stmt->bind_param("si", $image_path, $post_id);
        $stmt->execute();
        $stmt->close();

        header('Location: feed.php');
        exit();
    } else {
        echo "Desculpe, houve um erro ao enviar seu arquivo.";
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Foto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>Editar Foto</h1>
        <form action="edit_photo.php?post_id=<?php echo $post_id; ?>" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="image" class="form-label">Nova Imagem</label>
                <input class="form-control" type="file" id="image" name="image" required>
            </div>
            <button type="submit" class="btn btn-primary">Salvar</button>
        </form>
    </div>
</body>
</html>
