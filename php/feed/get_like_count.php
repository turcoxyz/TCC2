<?php
include 'config.php';

if (isset($_GET['post_id'])) {
    $post_id = $_GET['post_id'];

    $like_count_result = $conexao->query("SELECT COUNT(*) AS like_count FROM likes WHERE post_id = $post_id");
    $like_count_row = $like_count_result->fetch_assoc();
    echo $like_count_row['like_count'];
}
?>
