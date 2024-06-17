<?php
session_start();
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['post_id'])) {
    $post_id = $_POST['post_id'];

    $stmt = $conexao->prepare("SELECT image_path FROM posts WHERE id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $image_path = $row['image_path'];

        if (file_exists($image_path)) {
            unlink($image_path);
        }

        $stmt = $conexao->prepare("UPDATE posts SET image_path = '' WHERE id = ?");
        $stmt->bind_param("i", $post_id);
        $stmt->execute();
        $stmt->close();
        header('Location: feed.php');
        exit();
    }
}
?>
