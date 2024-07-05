<?php
session_start();
include 'config.php';
if ((!isset($_SESSION['email']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('location: ../pages/home.html');
}

$user_id = $_SESSION['user_id']; // assuming you store user_id in session

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

$stmt->close();
?>

<!doctype html>
<html lang="pt-BR" data-bs-theme="auto">

<head>

    <!-- <script src="../assets/js/color-modes.js"></script> -->

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
    <meta name="generator" content="Hugo 0.118.2">
    <title>ZooPet</title>
    <link rel="icon" href="../img/ZooPet Icone 2.png">

    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/blog/">
    <link rel="stylesheet" href="../pages/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/cssn?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../css/nightmode.css">




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
    <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">



    <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/blog/">
    <link rel="stylesheet" href="../../pages/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/cssn?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../../css/nightmode.css">




</head>

<body>



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


    <div class="container mt-5">
        <h1 class="titulo-ldt">Artigos</h1>
        <br><br><br>

        <div class="row">
            <div class="col-md-12 mb-4">
                <a href="" style="text-decoration: none; color: inherit">
                    <div class="card" style="width: 100%;">
                        <div class="row no-gutters">
                            <div class="col-md-3">
                                <img src="../img/capa-art2.png" class="card-img" alt="Capa Artigo 2">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h2 class="card-title">Principais Zoonoses</h2>
                                    <span>25 de abril de 2024</span>
                                    <p class="card-text">Zoonoses são doenças infecciosas transmitidas entre animais e humanos, causadas por vírus, bactérias, parasitas ou fungos. A transmissão pode ocorrer através de contato direto com animais, consumo de alimentos contaminados ou picadas de insetos. Exemplos incluem raiva e gripe aviária, sendo um importante desafio para a saúde pública.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <div class="col-md-12 mb-4">
                <a href="" style="text-decoration: none; color: inherit">
                    <div class="card" style="width: 100%;">
                        <div class="row no-gutters">
                            <div class="col-md-3">
                                <img src="../img/capa-art1.png" class="card-img" alt="Capa Artigo 1">
                            </div>
                            <div class="col-md-9">
                                <div class="card-body">
                                    <h2 class="card-title">Principais tipos de comidas venenosas para seu Cão e Gato</h2>
                                    <span>10 de abril de 2024</span>
                                    <p class="card-text">Este artigo explora os alimentos humanos que representam riscos tóxicos para cães e gatos, incluindo chocolate, cebola, uvas e abacate. Discute-se os sintomas associados e a importância da conscientização dos tutores para prevenir envenenamentos alimentares em animais de estimação.</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
















    <br><br><br><br><br><br><br><br><br><br>













    <footer class="rodape py-5 text-center text-body-secondary bg-body-tertiary">
        <p>Site projetado com elementos do <a href="https://getbootstrap.com/">Bootstrap</a> (Desenvolvido por: <a href="https://twitter.com/mdo">@mdo</a>).</p>
        <p> Site desenvolvido pela equipe PrimeTech para o trabalho de conclusão de curso. </p>
        </p>
    </footer>


</body>
<script src="../pages/feed.js"></script>
<script src="js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@1.16.1/dist/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
<script src="../js/nightmode.js"></script>

</html>