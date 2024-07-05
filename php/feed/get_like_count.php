<?php
include 'config.php';

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $stmt = $conexao->prepare("SELECT COUNT(*) AS like_count FROM likes WHERE post_id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $stmt->bind_result($like_count);
    $stmt->fetch();
    $stmt->close();

    echo $like_count;
}
?>
