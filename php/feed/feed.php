<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: /../../pages/home.html');
    exit();
}

$user_id = $_SESSION['user_id'];

// Função para curtir o post
function curtir($conexao, $post_id, $user_id)
{
    $stmt = $conexao->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Função para descurtir o post
function descurtir($conexao, $post_id, $user_id)
{
    $stmt = $conexao->prepare("DELETE FROM likes WHERE post_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Função para deletar comentários de uma publicação
function deletar_comentarios_por_publicacao($conexao, $post_id)
{
    $stmt = $conexao->prepare("DELETE FROM comments WHERE post_id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $stmt->close();
}

// Função para deletar likes de uma publicação
function deletar_likes_por_publicacao($conexao, $post_id)
{
    $stmt = $conexao->prepare("DELETE FROM likes WHERE post_id = ?");
    $stmt->bind_param("i", $post_id);
    $stmt->execute();
    $stmt->close();
}

// Função para deletar comentário
function deletar_comentario($conexao, $comentario_id, $user_id)
{
    $stmt = $conexao->prepare("DELETE FROM comments WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $comentario_id, $user_id);
    $stmt->execute();
    $stmt->close();
}

// Função para deletar publicação
function deletar_publicacao($conexao, $publicacao_id, $user_id)
{
    deletar_likes_por_publicacao($conexao, $publicacao_id);
    deletar_comentarios_por_publicacao($conexao, $publicacao_id);

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

$sql = "SELECT nm_user, nm_complete FROM usuarios WHERE id = ?";
$stmt = $conexao->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_name = $user['nm_user'];
    $user_complete_name = $user['nm_complete'];
} else {
    $user_name = "Usuário";
    $user_complete_name = "";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <!-- CSS -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="icon" href="../../img/ZooPet Icone 2.png">
<link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/blog/">

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
<link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&display=swap" rel="stylesheet">
<link href="../../css/cadastro.css" rel="stylesheet">
<link href="../../css/nightmode.css" rel="stylesheet">
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
<link rel="stylesheet" href="../../pages/style.css">


</head>

<body>

<link rel="stylesheet" href="../../css/navbar.css">

  <nav class="navbar navbar-expand-lg navbar-light navfundo justify-content-between">
    <div class="container">
      <a class="navbar-brand" href="../home.php"><img class="logo" src="../../img/ZooPet Logomarca.png" alt="">ZooPet</a>


      <div class="botoes">

        <a href="feed.php" class="bot-page">Feed</a>
        <a href="../artigos.php" class="bot-page">Artigos</a>
        <a href="../suporte.php" class="bot-page">Suporte</a>

      </div>


      <div class="botoes">

        <span class="text-white">Bem-vindo, <?php echo $user_name; ?>!</span>

        <form class="d-inline-flex">
          <!-- Dropdown menu -->
          <li class="nav dropdown">
            <a class="nav-link dropdown-toggle text-white" href="#" id="settingsDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
                <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
                <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
              </svg>
              <!-- Configurações -->
            </a>
            <div class="dropdown-menu dropdown-menu-dark" aria-labelledby="settingsDropdown">
              <a class="dropdown-item" href="../php/perfil.php">Gerenciar Conta</a>
              <div class="dropdown-item">
                <div class="form-check form-switch">
                  <input class="form-check-input" type="checkbox" id="chk">
                  <label class="form-check-label" for="chk">Modo Noturno</label>
                </div>
              </div>
              <div class="dropdown-divider"></div>
              <!-- <a class="dropdown-item" href="../pages/suporte.html">FAQ</a> -->
              <a href="sair.php" class="nav-link text-white">
                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                  <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"></path>
                  <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"></path>
                </svg> Sair
              </a>
            </div>
          </li>

          <!-- Log out button -->
          <li class="nav">
            <!-- <a href="sair.php" class="nav-link text-white">
              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
                <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"></path>
                <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"></path>
              </svg> Sair
            </a> -->
          </li>

        </form>
      </div>



    </div>
  </nav>

    <!-- FIM NAVBAR --------------------------------- -->

    <!-- FEED ------------------------------ -->

    <link rel="stylesheet" href="../../pages/feed.css">


    <div class="container mt-5">
        <h1 class="titulo-ldt">Linha do Tempo</h1>
        <h3>Criar publicação</h3>
        <form action="feed.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Título</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Conteúdo</label>
                <textarea class="form-control" id="content" name="content" rows="5" required></textarea>
            </div>
            <div class="mb-3">
                <label style="cursor:pointer;" for="image" class="form-label"><svg height="30px" width="30px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 280.067 280.067" xml:space="preserve">
                        <g id="SVGRepo_bgCarrier" stroke-width="0"></g>
                        <g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g>
                        <g id="SVGRepo_iconCarrier">
                            <g>
                                <path id="clip" style="fill:#000;" d="M149.823,257.142c-31.398,30.698-81.882,30.576-113.105-0.429 c-31.214-30.987-31.337-81.129-0.42-112.308l-0.026-0.018L149.841,31.615l14.203-14.098c23.522-23.356,61.65-23.356,85.172,0 s23.522,61.221,0,84.586l-125.19,123.02l-0.044-0.035c-15.428,14.771-40.018,14.666-55.262-0.394 c-15.244-15.069-15.34-39.361-0.394-54.588l-0.044-0.053l13.94-13.756l69.701-68.843l13.931,13.774l-83.632,82.599 c-7.701,7.596-7.701,19.926,0,27.53s20.188,7.604,27.88,0L235.02,87.987l-0.035-0.026l0.473-0.403 c15.682-15.568,15.682-40.823,0-56.39s-41.094-15.568-56.776,0l-0.42,0.473l-0.026-0.018l-14.194,14.089L50.466,158.485 c-23.522,23.356-23.522,61.221,0,84.577s61.659,23.356,85.163,0l99.375-98.675l14.194-14.089l14.194,14.089l-14.194,14.098 l-99.357,98.675C149.841,257.159,149.823,257.142,149.823,257.142z"></path>
                            </g>
                        </g>
                    </svg></label>
                <input class="form-control" type="file" id="image" name="image" style="display:none" onchange="readURL(this);">
                <img id="blah" src="#" alt="">



                <script>
                    function readURL(input) {
                        if (input.files && input.files[0]) {
                            var reader = new FileReader();
                            reader.onload = function(e) {
                                $('#blah')
                                    .attr('src', e.target.result)
                                    .width(300)
                                    .height(auto);
                            };
                            reader.readAsDataURL(input.files[0]);
                        }
                    }
                </script>


            </div>
            <!-- <svg height="20px" width="20px" version="1.1" id="Layer_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 280.067 280.067" xml:space="preserve" fill="#000000"><g id="SVGRepo_bgCarrier" stroke-width="0"></g><g id="SVGRepo_tracerCarrier" stroke-linecap="round" stroke-linejoin="round"></g><g id="SVGRepo_iconCarrier"> <g> <path style="fill:#000000;" d="M149.823,257.142c-31.398,30.698-81.882,30.576-113.105-0.429 c-31.214-30.987-31.337-81.129-0.42-112.308l-0.026-0.018L149.841,31.615l14.203-14.098c23.522-23.356,61.65-23.356,85.172,0 s23.522,61.221,0,84.586l-125.19,123.02l-0.044-0.035c-15.428,14.771-40.018,14.666-55.262-0.394 c-15.244-15.069-15.34-39.361-0.394-54.588l-0.044-0.053l13.94-13.756l69.701-68.843l13.931,13.774l-83.632,82.599 c-7.701,7.596-7.701,19.926,0,27.53s20.188,7.604,27.88,0L235.02,87.987l-0.035-0.026l0.473-0.403 c15.682-15.568,15.682-40.823,0-56.39s-41.094-15.568-56.776,0l-0.42,0.473l-0.026-0.018l-14.194,14.089L50.466,158.485 c-23.522,23.356-23.522,61.221,0,84.577s61.659,23.356,85.163,0l99.375-98.675l14.194-14.089l14.194,14.089l-14.194,14.098 l-99.357,98.675C149.841,257.159,149.823,257.142,149.823,257.142z"></path> </g> </g></svg> -->
            <button type="submit" class="btn btn-primary">Publicar</button>
        </form>

        <h2 class="mt-5">Publicações</h2>
        <?php
        $result = $conexao->query("SELECT p.id, p.user_id, p.title, p.content, p.image_path, p.created_at, u.nm_user, u.nm_complete FROM posts p JOIN usuarios u ON p.user_id = u.id ORDER BY p.created_at DESC");
        while ($row = $result->fetch_assoc()) :
            $post_id = $row['id'];
            $post_user_id = $row['user_id'];

            // Contar curtidas
            $like_count_result = $conexao->query("SELECT COUNT(*) AS like_count FROM likes WHERE post_id = $post_id");
            $like_count_row = $like_count_result->fetch_assoc();
            $like_count = $like_count_row['like_count'];

            // Verificar se o usuário curtiu o post
            $user_like_result = $conexao->query("SELECT id FROM likes WHERE post_id = $post_id AND user_id = $user_id");
            $user_liked = $user_like_result->num_rows > 0;

            // Formatar data e hora no formato brasileiro
            $created_at = new DateTime($row['created_at']);
            $created_at_formatted = $created_at->format('d/m/Y \à\s H:i');
        ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h6 class="card-subtitle mb-2 text-muted"><?php echo htmlspecialchars($row['nm_user']); ?> (<?php echo htmlspecialchars($row['nm_complete']); ?>)</h6>
                    <h5 class="card-title"><?php echo htmlspecialchars($row['title']); ?></h5>
                    <p class="card-text"><?php echo htmlspecialchars($row['content']); ?></p>
                    <?php if ($row['image_path']) : ?>
                        <a href="<?php echo htmlspecialchars($row['image_path']); ?>" data-lightbox="post-image">
                            <img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="card-img-top post-image" alt="...">
                        </a>
                    <?php endif; ?>
                    <p class="card-text"><small class="text-muted">Postado em <?php echo $created_at_formatted; ?></small></p>

                    <!-- Formulário de Curtir/Descurtir -->
                    <form action="feed.php" method="post" class="d-inline like-form" data-post-id="<?php echo $post_id; ?>">
                        <input type="hidden" name="like_post_id" value="<?php echo $post_id; ?>">
                        <button type="submit" class="btn btn-outline-primary btn-sm like-btn">
                            <?php if ($user_liked) echo 'Descurtir';
                            else echo 'Curtir'; ?>
                        </button>
                    </form>
                    <span class="like-count"><?php echo $like_count; ?> curtidas</span>

                    <!-- Dropdown de edição -->
                    <?php if ($post_user_id == $user_id) : ?>

                        <!-- Default dropend button -->
                        
                        <div class="dropdown d-inline">
                            <button class="btn btn-outline-secondary btn-sm dropdown-togggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
  <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
</svg>
                            </button>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                <li><a class="dropdown-item" href="edit_post.php?post_id=<?php echo $post_id; ?>">Editar Publicação</a></li>
                                <?php if ($row['image_path']) : ?>
                                    <li><a class="dropdown-item" href="edit_photo.php?post_id=<?php echo $post_id; ?>">Editar Foto</a></li>
                                <?php endif; ?>
                                <li>
                                    <form action="feed.php" method="post" class="d-inline">
                                        <input type="hidden" name="delete_post_id" value="<?php echo $post_id; ?>">
                                        <button type="submit" class="dropdown-item">Deletar Publicação</button>
                                    </form>
                                </li>
                            </ul>
                        </div>
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
                    $comment_result = $conexao->query("SELECT c.id, c.user_id, c.comment, c.created_at, u.nm_user, u.nm_complete FROM comments c JOIN usuarios u ON c.user_id = u.id WHERE c.post_id = $post_id ORDER BY c.created_at ASC");
                    while ($comment_row = $comment_result->fetch_assoc()) :
                        $comment_user_id = $comment_row['user_id'];
                        $comment_created_at = new DateTime($comment_row['created_at']);
                        $comment_created_at_formatted = $comment_created_at->format('d/m/Y \à\s H:i');
                    ?>
                        <div class="mt-3">
                            <strong><?php echo htmlspecialchars($comment_row['nm_user']); ?> (<?php echo htmlspecialchars($comment_row['nm_complete']); ?>):</strong>
                            <p><?php echo htmlspecialchars($comment_row['comment']); ?></p>
                            <small class="text-muted"><?php echo $comment_created_at_formatted; ?></small>
                            <?php if ($comment_user_id == $user_id) : ?>
                                <div class="dropdown d-inline">
                                    <button class="btn btn-outline-secondary btn-sm dropdown-toggle" type="button" id="dropdownMenuButtonComment" data-bs-toggle="dropdown" aria-expanded="false">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-three-dots" viewBox="0 0 16 16">
  <path d="M3 9.5a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3m5 0a1.5 1.5 0 1 1 0-3 1.5 1.5 0 0 1 0 3"/>
</svg>
                                    </button>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButtonComment">
                                        <li><a class="dropdown-item" href="edit_comment.php?comment_id=<?php echo $comment_row['id']; ?>">Editar Comentário</a></li>
                                        <li>
                                            <form action="feed.php" method="post" class="d-inline">
                                                <input type="hidden" name="delete_comment_id" value="<?php echo $comment_row['id']; ?>">
                                                <button type="submit" class="dropdown-item">Deletar Comentário</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
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
                            data: {
                                post_id: postId
                            },
                            success: function(data) {
                                likeCountSpan.text(data + ' curtidas');
                            }
                        });
                    }
                });
            });
        });
    </script>
     <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>
     <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</body>
<script src="../../pages/feed.js"></script>
<script src="../../js/bootstrap.bundle.min.js"></script>
<script src="../../js/nightmode.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</html>
<?php
$conexao->close();
?>