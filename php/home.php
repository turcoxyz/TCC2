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

</html>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ZOOPET SISTEMA</title>
  <script src="/assets/js/color-modes.js"></script>

  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="description" content="">
  <meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
  <meta name="generator" content="Hugo 0.118.2">
  <title>ZooPet</title>
  <link rel="icon" href="/img/ZooPet Icone 2.png">

  <link rel="canonical" href="https://getbootstrap.com/docs/5.3/examples/blog/">
  <link rel="stylesheet" href="/pages/style.css">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/@docsearch/css@3">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Playfair&#43;Display:700,900&amp;display=swap" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
  <link rel="stylesheet" href="/pages/cadastro.css">
  <link rel="stylesheet" href="../css/nightmode.css">
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
    <a class="navbar-brand" href="home.php">
      <img class="logo" src="/img/ZooPet Logomarca.png" alt="ZooPet Logo">
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
          </li><a class="dropdown-item" href="../php/feed.php">FEED</a></li>
          <li><hr class="dropdown-divider"></li>
          <li><a class="dropdown-item" href="../pages/suporte.html">FAQ</a></li>
        </ul>
      </div>

      <!-- Log out button -->
      <a href="/php/sair.php" class="btn btn-outline-light">
        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-box-arrow-right" viewBox="0 0 16 16">
          <path fill-rule="evenodd" d="M10 12.5a.5.5 0 0 1-.5.5h-8a.5.5 0 0 1-.5-.5v-9a.5.5 0 0 1 .5-.5h8a.5.5 0 0 1 .5.5v2a.5.5 0 0 0 1 0v-2A1.5 1.5 0 0 0 9.5 2h-8A1.5 1.5 0 0 0 0 3.5v9A1.5 1.5 0 0 0 1.5 14h8a1.5 1.5 0 0 0 1.5-1.5v-2a.5.5 0 0 0-1 0z"></path>
          <path fill-rule="evenodd" d="M15.854 8.354a.5.5 0 0 0 0-.708l-3-3a.5.5 0 0 0-.708.708L14.293 7.5H5.5a.5.5 0 0 0 0 1h8.793l-2.147 2.146a.5.5 0 0 0 .708.708z"></path>
        </svg> Sair
      </a>
    </div>
  </div>
</nav>

<body>
  <br><br>
  <br><br>
  <!--CONTEUDO-->

  <main class="topo container">

    <!-- TESTE CARROSSEL -->

    <div id="carouselExampleIndicators" class="carousel slide">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>
      <div class="carousel-inner">
        <div class="carousel-item active">
          <a href="registro.php"><img class="anuncio" src="../img/slide-cadastro.png" class="d-block w-100" alt="..."></a>
        </div>
        <div class="carousel-item">
          <a href="https://mongagua.sp.gov.br/noticias/saude/equipes-da-uvz-realizam-orientacoes-sobre-leishmaniose-visceral" target="_blank"><img class="anuncio" src="../img/slide-2.png" class="d-block w-100" alt="..."></a>
        </div>
        <div class="carousel-item">
          <a href="https://www.diariodolitoral.com.br/variedades/saude/mongagua-agenda-mais-uma-nebulizacao-contra-dengue-saiba-onde/180179/" target="_blank"><img class="anuncio" src="../img/slide-3.png" class="d-block w-100" alt="..."></a>
        </div>

      </div>
      <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Previous</span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
        <span class="carousel-control-next-icon" aria-hidden="true"></span>
        <span class="visually-hidden">Next</span>
      </button>
    </div>

    <!-- Fim Carrossel -->

    <main class="topo container">
      <div class="row mb-2">
        <div class="col-md-6">
          <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col p-4 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-warning-emphasis">Redes Sociais</strong>
              <h3 class="mb-0">Siga a PrimeTech no instagram!</h3>
              <div class="mb-1 text-body-secondary">04 Abr</div>
              <p class="card-text mb-auto">Siga a gente para conteúdo sobre animais de estimação!</p>
              <a href="https://instagram.com/equipe.PrimeTech" target="_blank" class="icon-link gap-1 icon-link-hover stretched-link">

                <svg class="bi">
                  <use xlink:href="#chevron-right" />
                </svg>
              </a>
            </div>
            <div class="col-auto d-none d-lg-block">
              <img class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false" src="../img/PrimeTech Insta.png" style="object-fit: cover;">

            </div>
          </div>
        </div>
        <div class="col-md-6">
          <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
            <div class="col p-4 d-flex flex-column position-static">
              <strong class="d-inline-block mb-2 text-danger-emphasis">Doenças</strong>
              <h3 class="mb-0">O que é Zoonose?</h3>
              <div class="mb-1 text-body-secondary">11 Ago</div>
              <p class="mb-auto">Se informe sobre os tipos de zoonose e os riscos que existem.</p>
              <a href="https://www.tuasaude.com/zoonose/" target="_blank" class="icon-link gap-1 icon-link-hover stretched-link">
                Ver Mais...
                <svg class="bi">
                  <use xlink:href="#chevron-right" />
                </svg>
              </a>
            </div>
            <div class="col-auto d-none d-lg-block">
              <img src="../img/capa_artigo_zoonose.png" style="object-fit: contain;" class="bd-placeholder-img" width="200" height="250" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder: Thumbnail" preserveAspectRatio="xMidYMid slice" focusable="false">
            </div>
          </div>
        </div>
      </div>

      <div class="row g-5">
        <div class="col-md-8">
          <h3 class="pb-4 mb-4 fst-italic border-bottom">

          </h3>

          <article class="blog-post">
            <h2 class="display-5  mb-1">Feed</h2>
            <p class="blog-post-meta"></p>

            <p>Feed para anúncio de adoções, reportagens de animais desaparecidos e animais encontrados.</p>
            <hr>

            <!-- FEED .............................................................................. -->

            <link rel="stylesheet" href="../pages/feed.css">

            <div>
              <div class="feed-post">
                <div class="user-info">
                  <a href="" class=""><img class="profile-picture" src="../img/PFPS/beautiful-woman-avatar-profile-icon-vector.png" alt=""></a>
                  <div class="column-content">
                    <div class="row-content">
                      <a href="#" class="nome-usuario">
                        <p>Lucia Santos</p>
                      </a>

                      <a href="#" class="username-at">
                        <p>@lucia_santos123 · 2h</p>
                      </a>
                    </div>
                    <div class="row-content">
                      <p class="label-adocao">ADOÇÃO</p>
                    </div>
                  </div>
                </div>
                <div class="post-content">
                  <div class="post-content-border">
                    <span class="content-text">Minha cachorrinha acaba de dar à luz a uma ninhada de
                      filhotes adoráveis e estamos procurando lares amorosos para eles! São cinco
                      filhotinhos, todos saudáveis e cheios de vida. Não podemos cuidar deles,
                      então se você está interessado em adotar um desses pequenos tesouros e dar a
                      eles um lar amoroso, por favor, entre em contato o mais rápido possível.
                      Eles estão prontos para encontrar suas famílias para sempre! 🏡❤️ </span>
                    <br><br>
                    <img id="content-image" data-enlargable src="/img/Five-cute-puppies-are-rescued-after-being-cruelly-bagged-up-and-thrown-into-ravine-2.jpg" alt="">
                  </div>
                </div>
                <div class="interaction">
                  <div class="interaction-buttons">
                    <img id="like-button" onclick="curtir()" src="../img/like0.png" alt="like">
                    <img id="share-button" src="../img/share.png" alt="compartilhar">
                  </div>
                  <div class="comentario-box"><input class="comentario-campo" placeholder="Comente aqui..." type="text"></div>
                </div>
              </div>

              <br>

              <div class="feed-post">
                <div class="user-info">
                  <a href="" class=""><img class="profile-picture" src="../img/PFPS/beautiful-latin-woman-avatar-character-icon-free-vector.png" alt=""></a>
                  <div class="column-content">
                    <div class="row-content">
                      <a href="#" class="nome-usuario">
                        <p>Marcia Meireles</p>
                      </a>

                      <a href="#" class="username-at">
                        <p>@marciamei_ · 7h</p>
                      </a>
                    </div>
                    <div class="row-content">
                      <p class="label-animal-perdido">ANIMAL PERDIDO</p>
                    </div>
                  </div>
                </div>
                <div class="post-content">
                  <div class="post-content-border">
                    <span class="content-text">Amigos, estou desesperadamente procurando pelo meu
                      amado gato, o Simba, que desapareceu hoje pela manhã. Ele é um gato macho,
                      peludo, com pelo branco, e olhos verdes. O Simba
                      é muito carinhoso, mas pode estar assustado, pois é a primeira vez que ele
                      sai de casa. Ele foi visto pela última vez perto da rua principal do bairro.
                      <br><br>
                      Por favor, se você mora na área ou conhece alguém que possa ter visto um
                      gato parecido, entre em contato imediatamente. Estamos muito preocupados com
                      o bem-estar dele e sua segurança. O Simba é parte da nossa família e estamos
                      desesperados para tê-lo de volta em casa. Qualquer informação é extremamente
                      importante. Compartilhem essa mensagem para nos ajudar a trazer o Simba de
                      volta para casa. Muito obrigado pela sua ajuda! 🙏🐱❤️ </span>
                    <br><br>
                    <img id="content-image" data-enlargable src="../img/gatobranco.jpg" alt="">
                  </div>
                </div>
                <div class="interaction">
                  <div class="interaction-buttons">
                    <img id="like-button" onclick="curtir()" src="/img/like0.png" alt="like">
                    <img id="share-button" src="../img/share.png" alt="compartilhar">
                  </div>
                  <div class="comentario-box"><input class="comentario-campo" placeholder="Comente aqui..." type="text"></div>
                </div>
              </div>
            </div>
            <!-- FEED .............................................................................. -->

        </div>

        <div class="col-md-4">
          <div class="position-sticky" style="top: 2rem;">
            <div class="p-4 mb-3 bg-body-tertiary rounded">
              <h3 style="font-weight: bold;">Contato</h3>
              <h5 style="font-weight: bold;">Centro de Controle Zoonose</h5>
              <p class="mb-0"> Telefone: (13) 3507-5479</p>
              <p class="mb-0"> Endereço: Av. São Paulo, 4836-4974 - Balneario Umurama - Balneario Umurama,
                Mongaguá - SP, 11730-000</p>
            </div>

            <div>
              <h4 class="fst-italic">Publicaçoes Recentes</h4>
              <ul class="list-unstyled">
                <li>
                  <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="/pages/artigo1.html">
                    <img class="bd-placeholder-img" width="100%" height="96" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
                    <img src="/img/capa-art1.png" width="114px" height="96px" fill="#777" />
                    </svg>
                    <div class="col-lg-8">
                      <h6 class="mb-0">Comidas venenosas para cães e gatos</h6>
                      <small class="text-body-secondary">25 de Abril, 2024</small>
                    </div>
                  </a>
                </li>
                <li>
                  <a class="d-flex flex-column flex-lg-row gap-3 align-items-start align-items-lg-center py-3 link-body-emphasis text-decoration-none border-top" href="artigo2.html">
                    <svg class="bd-placeholder-img" width="100%" height="96" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" preserveAspectRatio="xMidYMid slice" focusable="false">
                      <img src="/img/capa-art2.png" width="114px" height="96px" fill="#777" />
                    </svg>
                    <div class="col-lg-8">
                      <h6 class="mb-0">Doenças de animais de estimação</h6>
                      <small class="text-body-secondary">3 de Maio, 2024</small>
                    </div>
                  </a>
                </li>
              </ul>
            </div>


          </div>
        </div>
      </div>

    </main>

    <br><br><br>

    <footer class="py-5 text-center text-body-secondary bg-body-tertiary">
      <p>Site projetado com elementos do <a href="https://getbootstrap.com/">Bootstrap</a> (Desenvolvido por: <a href="https://twitter.com/mdo">@mdo</a>).</p>
      <p> Site desenvolvido pela equipe PrimeTech para o trabalho de conclusão de curso. </p>
    </footer>


</body>
<script src="../pages/feed.js"></script>
<script src="../js/java.js"></script>



</html>