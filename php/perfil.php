<?php
session_start();
include_once('config.php');

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: ../login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

// Prepara a consulta para buscar as informações do usuário
$stmt = $conexao->prepare("SELECT nm_complete, nm_user, email, telefone, sexo_id, dt_nascimento, nm_bairro, endereco FROM usuarios WHERE id=?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$stmt->bind_result($nome, $nomeUser, $email, $telefone, $sexo_id, $dt_nascimento, $nm_bairro, $endereco);
$stmt->fetch();
$stmt->close();

// Mapeia o sexo_id para o valor de gênero
$sexo_map = [
    1 => 'masculino',
    2 => 'feminino',
    3 => 'outros'
];
$sexo = array_search($sexo_id, $sexo_map);

$profile_updated = false;
if (isset($_SESSION['profile_updated'])) {
    $profile_updated = true;
    unset($_SESSION['profile_updated']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>ZooPet - Editar Perfil</title>
    <link rel="icon" href="../img/ZooPet Icone 2.png">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/blog/">
    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/blog/">
  <link rel="stylesheet" href="../pages/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
<link rel="stylesheet" href="../css/cadastro.css">
<link rel="stylesheet" href="../css/nightmode.css">
    <script>
        function validatePassword() {
            var password = document.getElementsByName('password')[0].value;
            var confirm_password = document.getElementsByName('confirm_password')[0].value;
            if (password != confirm_password) {
                alert("As senhas não coincidem.");
                return false;
            }
            return true;
        }
    </script>
</head>


  <!-- NAVBAR ----------------- -->

  <link rel="stylesheet" href="../css/navbar.css">

<nav class="navbar navbar-expand-lg navbar-light navfundo justify-content-between">
  <div class="container">
    <a class="navbar-brand" href="home.php"><img class="logo" src="../img/ZooPet Logomarca.png" alt="">ZooPet</a>


    <div class="botoes">

    <a href="feed/feed.php" class="bot-page">Feed</a>
    <a href="artigos.php" class="bot-page">Artigos</a>
    <a href="suporte.php" class="bot-page">Suporte</a>

    </div>


    <div class="botoes">

      <span class="text-white">Bem-vindo, <?php echo $nomeUser; ?>!</span>

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

<script>
  // Função para alternar entre os modos claro e escuro
  function toggleDarkMode() {
    const body = document.body;

    if (body.classList.contains('dark')) {
      body.classList.remove('dark');
      localStorage.setItem('darkMode', 'false'); // Salva o estado do modo noturno
    } else {
      body.classList.add('dark');
      localStorage.setItem('darkMode', 'true'); // Salva o estado do modo noturno
    }
  }

  // Verifica se o modo noturno estava ativado anteriormente
  document.addEventListener('DOMContentLoaded', () => {
    const darkMode = localStorage.getItem('darkMode');

    if (darkMode === 'true') {
      document.body.classList.add('dark');
    }
  });
</script>

<body style="height:200px;">
<!-- 
    <br>
    <a href="home.php"><button class="btn-voltar">&hookleftarrow; Voltar</button></a>
    <br><br><br> -->

    <br><br><br><br><br>
    <div class="box">
        <?php if ($profile_updated): ?>
            <div class="alert alert-success" role="alert">
                Perfil atualizado com sucesso!
            </div>
        <?php endif; ?>
        <form action="update_profile.php" method="POST" onsubmit="return validatePassword()">
            <legend><b>Editar Perfil</b></legend>
            <br><br>
            <div class="inputbox">
                <input type="text" name="Nome" class="InputUser" value="<?php echo htmlspecialchars($nome); ?>" required>
                <label for="Nome" class="labelInput">Nome Completo</label>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="text" name="nomeUser" class="InputUser" value="<?php echo htmlspecialchars($nomeUser); ?>" required>
                <label for="nomeUser" class="labelInput">Nome de Usuario</label>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="text" name="email" class="InputUser" value="<?php echo htmlspecialchars($email); ?>" required>
                <label for="email" class="labelInput">Email</label>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="tel" name="telefone" class="InputUser" value="<?php echo htmlspecialchars($telefone); ?>" required>
                <label for="telefone" class="labelInput">(DDD)Telefone</label>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="password" name="current_password" class="InputUser" required>
                <label for="current_password" class="labelInput">Senha Atual</label>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="password" name="new_password" class="InputUser" required>
                <label for="new_password" class="labelInput">Nova Senha</label>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="password" name="confirm_password" class="InputUser" required>
                <label for="confirm_password" class="labelInput">Confirme a Senha</label>
            </div>
            <br><br>
            <p>Gênero</p>
            <input type="radio" name="genero" id="masculino" value="masculino" <?php echo $sexo == 'masculino' ? 'checked' : ''; ?> required>
            <label for="masculino">Masculino</label>
            <br>
            <input type="radio" name="genero" id="feminino" value="feminino" <?php echo $sexo == 'feminino' ? 'checked' : ''; ?> required>
            <label for="feminino">Feminino</label>
            <br>
            <input type="radio" name="genero" id="outros" value="outros" <?php echo $sexo == 'outros' ? 'checked' : ''; ?> required>
            <label for="outros">Outros</label>
            <br><br>
            <div class="inputbox">
                <label for="data_nascimento"><b>Data de Nascimento</b></label>
                <input type="date" name="data_nascimento" id="data_nascimento" value="<?php echo htmlspecialchars($dt_nascimento); ?>" required>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="text" name="bairro" class="InputUser" value="<?php echo htmlspecialchars($nm_bairro); ?>" required>
                <label for="bairro" class="labelInput">Nome do Bairro</label>
            </div>
            <br><br>
            <div class="inputbox">
                <input type="text" name="nm_rua" class="InputUser" value="<?php echo htmlspecialchars($endereco); ?>" required>
                <label for="nm_rua" class="labelInput">Endereço com Número</label>
            </div>
            <br><br>
            <input type="submit" name="submit" id="submit" value="Atualizar Perfil">
        </form>

    </div>
    <br><br><br><br><br><br>
</body>
<script src="../pages/feed.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
  <script src="../js/nightmode.js"></script>
</html>
