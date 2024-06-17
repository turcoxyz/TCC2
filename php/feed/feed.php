<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /../../pages/home.html');
    exit();
}

$user_id = $_SESSION['user_id'];

// Função para curtir o post
function curtir($conexao, $post_id, $user_id) {
    $stmt = $conexao->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Função para descurtir o post
function descurtir($conexao, $post_id, $user_id) {
    $stmt = $conexao->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Função para deletar comentários de uma publicação
function deletar_comentarios_por_publicacao($conexao, $post_id) {
    $stmt = $conexao->prepare("DELETE FROM comments WHERE post_id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $stmt->close();
}

// Função para deletar likes de uma publicação
function deletar_likes_por_publicacao($conexao, $post_id) {
    $stmt = $conexao->prepare("DELETE FROM likes WHERE post_id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $stmt->close();
}

// Função para deletar comentário
function deletar_comentario($conexao, $comentario_id, $user_id) {
    $stmt = $conexao->prepare("DELETE FROM comments WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $comentario_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Função para deletar publicação
function deletar_publicacao($conexao, $publicacao_id, $user_id) {
    // Deletar likes e comentários associados à publicação
    deletar_likes_por_publicacao($conexao, $publicacao_id);
    deletar_comentarios_por_publicacao($conexao, $publicacao_id);

    // Deletar a publicação
    $stmt = $conexao->prepare("DELETE FROM posts WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $publicacao_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Inserir postagem
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['content'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $image_path = '';

    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
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
        } else {
            echo "Desculpe, houve um erro ao enviar seu arquivo.";
            exit();
        }
    }

    $stmt = $conexao->prepare("INSERT INTO posts (user_id, title, content, image_path) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $user_id, $title, $content, $image_path);
    $stmt->execute();
    $stmt->close();

    header('Location: feed.php');
    exit();
}

// Inserir comentário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['comment'])) {
    $comment = $_POST['comment'];
    $post_id = $_POST['post_id'];

    $stmt = $conexao->prepare("INSERT INTO comments (post_id, user_id, comment) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $post_id, $user_id, $comment);
    $stmt->execute();
    $stmt->close();

    header('Location: feed.php');
    exit();
}

// Processar curtidas/descurtidas
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like_post_id'])) {
    $post_id = $_POST['like_post_id'];

    $stmt = $conexao->prepare("SELECT id FROM likes WHERE post_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $stmt->store_result();
    $user_liked = $stmt->num_rows > 0;
    $stmt->close();

    if ($user_liked) {
        descurtir($conexao, $post_id, $user_id);
    } else {
        curtir($conexao, $post_id, $user_id);
    }

    exit();
}

// Processar deletar publicação
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_post_id'])) {
    $post_id = $_POST['delete_post_id'];
    deletar_publicacao($conexao, $post_id, $user_id);
    header('Location: feed.php');
    exit();
}

// Processar deletar comentário
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_comment_id'])) {
    $comment_id = $_POST['delete_comment_id'];
    deletar_comentario($conexao, $comment_id, $user_id);
    header('Location: feed.php');
    exit();
}

$sql = "SELECT nm_user FROM usuarios WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_name = $user['nm_user'];
} else {
    $user_name = "Usuário";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="icon" href="/img/ZooPet Icone 2.png">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/blog/">
    <link rel="stylesheet" href="../../pages/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../pages/cadastro.css">
    <link rel="stylesheet" href="../../css/nightmode.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
    <style>
        .switch {
            position: relative;
            display: inline-block;
            width: 40px;
            height: 20px;
        }

        .switch input {
            opacity: 0;
            width: 0;
            height: 0;
        }

        .slider {
            position: absolute;
            cursor: pointer;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: #ccc;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 20px;
        }

        .slider:before {
            position: absolute;
            content: "";
            height: 16px;
            width: 16px;
            left: 2px;
            bottom: 2px;
            background-color: white;
            -webkit-transition: .4s;
            transition: .4s;
            border-radius: 50%;
        }

        input:checked+.slider {
            background-color: #2196F3;
        }

        input:checked+.slider:before {
            -webkit-transform: translateX(20px);
            -ms-transform: translateX(20px);
            transform: translateX(20px);
        }

        .slider.round {
            border-radius: 20px;
        }

        .slider.round:before {
            border-radius: 50%;
        }

        .post-image {
            width: 100%;
            max-width: 400px;
            height: auto;
            object-fit: cover;
        }
    </style>
</head>

<body>
    <div class="container mt-5">
        <h1>Feed de Publicações</h1>
        <form action="feed.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
            <label for="title" class="form-label">Titulo</label>
            <input type="text" class="form-control" id="title" name="title" required>
        </div>
        <div class="mb-3">
            <label for="content" class="form-label">Conteúdo</label>
            <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="image" class="form-label">Anexar fotos</label>
            <input class="form-control" type="file" id="image" name="image">
        </div>
        <button type="submit" class="btn btn-primary">Publicar</button>
    </form>

    <h2 class="mt-5">Publicações</h2>
    <?php
    $result = $conexao->query("SELECT p.id, p.user_id, p.title, p.content, p.image_path, p.created_at, u.nm_user FROM posts p JOIN usuarios u ON p.user_id = u.id ORDER BY p.created_at DESC");
    while ($row = $result->fetch_assoc()):
        $post_id = $row['id'];
        $post_user_id = $row['user_id'];

        // Contar curtidas
        $like_count_result = $conexao->query("SELECT COUNT(*) AS like_count FROM likes WHERE post_id = $post_id");
        $like_count_row = $like_count_result->fetch_assoc();
        $like_count = $like_count_row['like_count'];

        // Verificar se o usuário curtiu o post
        $user_like_result = $conexao->query("SELECT id FROM likes WHERE post_id = $post_id AND user_id = $user_id");
        $user_liked = $user_like_result->num_rows > 0;
    ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($row['nm_user']); ?></h6>
                <p class="card-text"><?php echo htmlspecialchars($row['content']); ?></p>
                <?php if ($row['image_path']): ?>
                    <a href="<?php echo htmlspecialchars($row['image_path']); ?>" data-lightbox="post-image">
                        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="card-img-top post-image" alt="...">
                    </a>
                <?php endif; ?>
                <p class="card-text"><small class="text-muted">Postado em <?php echo $row['created_at']; ?></small></p>

                <!-- Formulário de Curtir/Descurtir -->
                <form action="feed.php" method="post" class="d-inline like-form" data-post-id="<?php echo $post_id; ?>">
                    <input type="hidden" name="like_post_id" value="<?php echo $post_id; ?>">
                    <button type="submit" class="btn btn-outline-primary btn-sm like-btn">
                        <?php if ($user_liked) echo 'Descurtir'; else echo 'Curtir'; ?>
                    </button>
                </form>
                <span class="like-count"><?php echo $like_count; ?> curtidas</span>

                <!-- Botões de edição -->
                <?php if ($post_user_id == $user_id): ?>
                    <a href="edit_post.php?post_id=<?php echo $post_id; ?>" class="btn btn-outline-secondary btn-sm">Editar Publicação</a>
                    <?php if ($row['image_path']): ?>
                        <a href="edit_photo.php?post_id=<?php echo $post_id; ?>" class="btn btn-outline-secondary btn-sm">Editar Foto</a>
                    <?php endif; ?>
                    <!-- Formulário de Deletar Publicação -->
                    <form action="feed.php" method="post" class="d-inline">
                        <input type="hidden" name="delete_post_id" value="<?php echo $post_id; ?>">
                        <button type="submit" class="btn btn-outline-danger btn-sm">Deletar Publicação</button>
                    </form>
                <?php endif; ?>

                <!-- Formulário de Comentário -->
                <form action="feed.php" method="post" class="mt-2">
                    <div class="input-group">
                        <input type="text" name="comment" class="form-control" placeholder="Comente aqui..." required>
                        <input type="hidden" name="post_id" value="<?php echo $post_id; ?>">
                        <button type="submit" class="btn btn-primary">Comentar</button>
                    </div>
                </form>

                <!-- Exibir Comentários -->
                <?php
                $comment_result = $conexao->query("SELECT c.id, c.user_id, c.comment, c.created_at, u.nm_user FROM comments c JOIN usuarios u ON c.user_id = u.id WHERE c.post_id = $post_id ORDER BY c.created_at ASC");
                while ($comment_row = $comment_result->fetch_assoc()):
                    $comment_user_id = $comment_row['user_id'];
                ?>
                    <div class="mt-3">
                        <strong><?php echo htmlspecialchars($comment_row['nm_user']); ?>:</strong>
                        <p><?php echo htmlspecialchars($comment_row['comment']); ?></p>
                        <small class="text-muted"><?php echo $comment_row['created_at']; ?></small>
                        <?php if ($comment_user_id == $user_id): ?>
                            <a href="edit_comment.php?comment_id=<?php echo $comment_row['id']; ?>" class="btn btn-outline-secondary btn-sm">Editar Comentário</a>
                            <!-- Formulário de Deletar Comentário -->
                            <form action="feed.php" method="post" class="d-inline">
                                <input type="hidden" name="delete_comment_id" value="<?php echo $comment_row['id']; ?>">
                                <button type="submit" class="btn btn-outline-danger btn-sm">Deletar Comentário</button>
                            </form>
                        <?php endif; ?>
                    </div>
                <?php endwhile; ?>
            </div>
        </div>
    <?php endwhile; ?>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        $('.like-form').on('submit', function(e) {
            e.preventDefault();
            var form = $(this);
            var postId = form.data('post-id');
            var button = form.find('.like-btn');
            var likeCountSpan = form.next('.like-count');

            $.ajax({
                type: 'POST',
                url: 'feed.php',
                data: form.serialize(),
                success: function() {
                    if (button.text() === 'Curtir') {
                        button.text('Descurtir');
                        button.removeClass('btn-outline-primary').addClass('btn-outline-secondary');
                    } else {
                        button.text('Curtir');
                        button.removeClass('btn-outline-secondary').addClass('btn-outline-primary');
                    }

                    // Atualizar contagem de curtidas
                    $.ajax({
                        url: 'get_like_count.php',
                        type: 'GET',
                        data: { post_id: postId },
                        success: function(data) {
                            likeCountSpan.text(data + ' curtidas');
                        }
                    });
                }
            });
        });
    });
</script>
<script src="../../java.js"></script>
<script src="../../js/java.js"></script>
</body>
</html>
<?php
// Fechar conexão
$conexao->close();
?>