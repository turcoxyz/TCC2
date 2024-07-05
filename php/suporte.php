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



    <!--Section: FAQ-->
    <section>
        <!-- <h3 class="text-center mb-4 pb-2 text-primary fw-bold">Duvidas Frequentes</h3>
		<p class="text-center mb-5">
			Resoluçao de duvidas mais frequentes de usuarios!
		</p>

		<div class="row">
			<div class="col-md-6 col-lg-4 mb-4">
				<h6 class="mb-3 text-primary"><i class="far fa-paper-plane text-primary pe-2"></i> Sobre as Vacinas?
				</h6>
				<p>
					<strong><u>Certo!</u></strong> Entre em contato com nossa equipe de colaboradores, pelo nosso
					Whatsapp ou Ligue <strong>(xxxx-xxxx)</strong> .
				</p>
			</div>

			<div class="col-md-6 col-lg-4 mb-4">
				<h6 class="mb-3 text-primary"><i class="fas fa-pen-alt text-primary pe-2"></i> Como consigo o beneficio
					da gratuidade de vacinas e chipagem para o meu pet?</h6>
				<p>
					<strong><u>OK</u></strong>, Você precisa primeiro comprovar que sua renda familiar seja estado de
					baixa renda (comprovante de baixa renda, ou Numero do Cadrasto Unico ou de algum outro beneficio),
					caso contrario a Zoonose pode cobrar alguma taxa por estes serviços.
				</p>
			</div>

			<div class="col-md-6 col-lg-4 mb-4">
				<h6 class="mb-3 text-primary"><i class="fas fa-user text-primary pe-2"></i> Como Funciona o sistema de
					adoção?</h6>
				<p>
					Atualmente, o sistema de adoção é somente pessoalmente , indo a unidade da Zoonose em Mongaguá/SP,
					porém temos planos futuramente de aderir a um sistema de adoção digital onde o apadrinhado somente
					retira o Pet presencialmente.
				</p>
			</div> -->

        <br>

        <section class="ftco-section">
            <div class="container">

                <div class="row justify-content-center">
                    <div class="col-md-12">
                        <div class="wrapper">
                            <div class="row no-gutters mb-5">
                                <div class="col-md-7">
                                    <div class="contact-wrap w-100 p-md-5 p-4">

                                        <h2 style="font-weight: bolder;">Contato do Centro de Controle Zoonose</h2>
                                        <h3 style="font-weight: bold;"> Telefone: </h3>
                                        <h4 class="mb-0">(13) 3507-5479</h4>
                                        <br>
                                        <h3 style="font-weight: bold;"> Endereço: </h3>
                                        <h4 class="mb-0">Av. São Paulo, 4836-4974 - Balneario Umurama - Balneario Umurama,
                                            Mongaguá - SP, 11730-000</h4>

                                            <br>

                                        <h2 style="font-weight: bolder;">Suporte do site</h2>
                                        <h3 style="font-weight: bold;"> E-mail: </h3>
                                        <h4 class="mb-0">gustavopl.contato@gmail.com</h4>

                                    </div>
                                </div>
                                <div class="col-md-5 d-flex align-items-stretch">
                                    <div id="map"><iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d455.2483712383388!2d-46.63661153674309!3d-24.101953688712328!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x94ce279f5468d273%3A0xbfb9000448f72355!2sCentro%20De%20Controle%20Zoonose!5e0!3m2!1spt-BR!2sbr!4v1711146621144!5m2!1spt-BR!2sbr" width="600" height="450" style="border:0;" allowfullscreen="" loading="lazy" referrerpolicy="no-referrer-when-downgrade"></iframe>
                                    </div>
                                </div>
                            </div>
                            <!-- <div class="row">
                                <div class="col-md-3">
                                    <div class="dbox w-100 text-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-map-marker"></span>
                                        </div>
                                        <div class="text">
                                            <p><span>Endereço:</span> Av. São Paulo, 4836-4974 - Balneario Umurama -
                                                Balneario Umurama, Mongaguá - SP, 11730-000</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="dbox w-100 text-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-phone"></span>
                                        </div>
                                        <div class="text">
                                            <p><span>Telefone:</span> <a href="tel://1234567920">(013)35075479</a>
                                            </p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="dbox w-100 text-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-paper-plane"></span>
                                        </div>
                                        <div class="text">
                                            <p><span>Email:</span> <a href="mailto:info@yoursite.com">xxx</a></p>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="dbox w-100 text-center">
                                        <div class="icon d-flex align-items-center justify-content-center">
                                            <span class="fa fa-globe"></span>
                                        </div>
                                        <div class="text">
                                            <p><span>Website</span> <a href="#">yoursite.com</a></p>
                                        </div>
                                    </div>
                                </div>
                            </div> -->
                        </div>
                    </div>
                </div>
            </div>
        </section>

    </section>
    <!--Section: FAQ-->

    <!-- aba redes sociais -->
    <div class="sharebuttons btn-group">
        <!-- <a href="#" class="btn btn-twitter" target="_blank"><i class="fa fa-twitter"></i> <span>Tweet</span></a> -->
        <!-- <a href="#" class="btn btn-instagram" target="_blank"><i style="width: 300px;" class="fa fa-instagram"></i> <span>insta</span></a> -->
        <!-- <a href="#" class="btn btn-facebook" target="_blank"><i class="fa fa-facebook"></i> <span>face</span></a> -->
    </div>

    </main>

    <!--FIM DO CONTEUDO-->

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