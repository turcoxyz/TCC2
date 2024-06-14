<?php
session_start();
include 'config.php';

if (!isset($_SESSION['user_id'])) {
    header('Location: ../pages/home.html');
    exit();
}

$user_id = $_SESSION['user_id'];

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

// Inserir curtida
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['like_post_id'])) {
    $post_id = $_POST['like_post_id'];

    // Verificar se o usuário já curtiu o post
    $stmt = $conexao->prepare("SELECT id FROM likes WHERE post_id = ? AND user_id = ?");
    $stmt->bind_param("ii", $post_id, $user_id);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        // Inserir nova curtida
        $stmt->close();
        $stmt = $conexao->prepare("INSERT INTO likes (post_id, user_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $post_id, $user_id);
        $stmt->execute();
    }
    $stmt->close();

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
  </style>
</head>

<nav class="navbar navbar-expand-lg navbar-light justify-content-between" style="background: #49745f;">
  <div class="container">
    <a class="navbar-brand" href="../home.php">
      <img class="logo" src="../../img/ZooPet Logomarca.png" alt="ZooPet Logo">
      ZooPet
    </a>

    <div class="d-flex align-items-center text-white">
      <span class="me-4">Bem-vindo, <?php echo $user_name; ?>!</span>

      <!-- Dropdown menu -->
      <div class="dropdown">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="settingsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
          <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-gear" viewBox="0 0 16 16">
            <path d="M8 4.754a3.246 3.246 0 1 0 0 6.492 3.246 3.246 0 0 0 0-6.492M5.754 8a2.246 2.246 0 1 1 4.492 0 2.246 2.246 0 0 1-4.492 0" />
            <path d="M9.796 1.343c-.527-1.79-3.065-1.79-3.592 0l-.094.319a.873.873 0 0 1-1.255.52l-.292-.16c-1.64-.892-3.433.902-2.54 2.541l.159.292a.873.873 0 0 1-.52 1.255l-.319.094c-1.79.527-1.79 3.065 0 3.592l.319.094a.873.873 0 0 1 .52 1.255l-.16.292c-.892 1.64.901 3.434 2.541 2.54l.292-.159a.873.873 0 0 1 1.255.52l.094.319c.527 1.79 3.065 1.79 3.592 0l.094-.319a.873.873 0 0 1 1.255-.52l.292.16c1.64.893 3.434-.902 2.54-2.541l-.159-.292a.873.873 0 0 1 .52-1.255l.319-.094c1.79-.527 1.79-3.065 0-3.592l-.319-.094a.873.873 0 0 1-.52-1.255l.16-.292c.893-1.64-.902-3.433-2.541-2.54l-.292.159a.873.873 0 0 1-1.255-.52zm-2.633.283c.246-.835 1.428-.835 1.674 0l.094.319a1.873 1.873 0 0 0 2.693 1.115l.291-.16c.764-.415 1.6.42 1.184 1.185l-.159.292a1.873 1.873 0 0 0 1.116 2.692l.318.094c.835.246.835 1.428 0 1.674l-.319.094a1.873 1.873 0 0 0-1.115 2.693l.16.291c.415.764-.42 1.6-1.185 1.184l-.291-.159a1.873 1.873 0 0 0-2.693 1.116l-.094.318c-.246.835-1.428.835-1.674 0l-.094-.319a1.873 1.873 0 0 0-2.692-1.115l-.292.16c-.764.415-1.6-.42-1.184-1.185l.159-.291A1.873 1.873 0 0 0 1.945 8.93l-.319-.094c-.835-.246-.835-1.428 0-1.674l.319-.094A1.873 1.873 0 0 0 3.06 4.377l-.16-.292c-.415-.764.42-1.6 1.185-1.184l.292.159a1.873 1.873 0 0 0 2.692-1.115z" />
          </svg>
        </button>
        <ul class="dropdown-menu dropdown-menu-dark" aria-labelledby="settingsDropdown">
          <li><a class="dropdown-item" href="../php/perfil.php">Gerenciar Conta</a></li>
          <li class="dropdown-item">
            <div class="form-check form-switch">
              <input class="form-check-input" type="checkbox" id="chk">
              <label class="form-check-label" for="chk">Modo Noturno</label>
            </div>
          </li><a class="dropdown-item" href="../../php/feed.php">FEED</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="../../pages/suporte.html">FAQ</a></li>
        </ul>
      </div>

      <!-- Log out button -->
      <a href="/../php/sair.php" class="btn btn-outline-light">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"></path>
          <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"></path>
        </svg> Sair
      </a>
    </div>
  </div>
</nav>

<body>
    <div class="container mt-5">
        <h1>Feed</h1>
        <form action="feed.php" method="post" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Title</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            <div class="mb-3">
                <label for="content" class="form-label">Content</label>
                <textarea class="form-control" id="content" name="content" rows="3" required></textarea>
            </div>
            <div class="mb-3">
                <label for="image" class="form-label">Attach Image</label>
                <input class="form-control" type="file" id="image" name="image">
            </div>
            <button type="submit" class="btn btn-primary">Post</button>
        </form>

        <h2 class="mt-5">Posts</h2>
        <?php
        $result = $conexao->query("SELECT p.id, p.title, p.content, p.image_path, p.created_at, u.nm_user FROM posts p JOIN usuarios u ON p.user_id = u.id ORDER BY p.created_at DESC");
        while ($row = $result->fetch_assoc()):
            $post_id = $row['id'];

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
                        <img src="<?php echo htmlspecialchars($row['image_path']); ?>" class="card-img-top" alt="...">
                    <?php endif; ?>
                    <p class="card-text"><small class="text-muted">Posted on <?php echo $row['created_at']; ?></small></p>

                    <!-- Formulário de Curtida -->
                    <form action="feed.php" method="post" class="d-inline">
                        <input type="hidden" name="like_post_id" value="<?php echo $post_id; ?>">
                        <button type="submit" class="btn btn-outline-primary btn-sm" <?php if ($user_liked) echo 'disabled'; ?>>
                            <?php if ($user_liked) echo 'Curtido'; else echo 'Curtir'; ?>
                        </button>
                    </form>
                    <span><?php echo $like_count; ?> curtidas</span>

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
                    $comment_result = $conexao->query("SELECT c.comment, c.created_at, u.nm_user FROM comments c JOIN usuarios u ON c.user_id = u.id WHERE c.post_id = $post_id ORDER BY c.created_at ASC");
                    while ($comment_row = $comment_result->fetch_assoc()):
                    ?>
                        <div class="mt-3">
                            <strong><?php echo htmlspecialchars($comment_row['nm_user']); ?>:</strong>
                            <p><?php echo htmlspecialchars($comment_row['comment']); ?></p>
                            <small class="text-muted"><?php echo $comment_row['created_at']; ?></small>
                        </div>
                    <?php endwhile; ?>
                </div>
            </div>
        <?php endwhile; ?>
    </div>
    

</body>
<script src="../../java.js"></script>
<script src="../../js/java.js"></script>
</html>
