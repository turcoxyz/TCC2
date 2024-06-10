<?php
session_start();
include_once('config.php');

// Verifica se o usuário está autenticado
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['user_id'];

if (isset($_POST['submit'])) {
    $current_password = $_POST['current_password'];
    $nome = $_POST['Nome'];
    $nomeUser = $_POST['nomeUser'];
    $email = $_POST['email'];
    $telefone = $_POST['telefone'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];
    $sexo = $_POST['genero'];
    $dt_nascimento = $_POST['data_nascimento'];
    $nm_bairro = $_POST['bairro'];
    $endereco = $_POST['nm_rua'];

    // Verifica a senha atual
    $stmt = $conexao->prepare("SELECT senha FROM usuarios WHERE id=?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $stmt->bind_result($hashed_password);
    $stmt->fetch();
    $stmt->close();

    if (!password_verify($current_password, $hashed_password)) {
        echo "Senha atual incorreta.";
        exit;
    }

    if ($new_password !== $confirm_password) {
        echo "As senhas não coincidem.";
        exit;
    }

    // Hash da nova senha
    $hashed_new_password = password_hash($new_password, PASSWORD_BCRYPT);

    // Converter o valor de sexo para sexo_id
    $sexo_map = [
        'masculino' => 1,
        'feminino' => 2,
        'outros' => 3
    ];

    if (!array_key_exists($sexo, $sexo_map)) {
        echo "Gênero inválido.";
        exit;
    }

    $sexo_id = $sexo_map[$sexo];

    // Prepara a consulta de atualização
    $stmt = $conexao->prepare("UPDATE usuarios SET nm_complete=?, nm_user=?, email=?, telefone=?, senha=?, sexo_id=?, dt_nascimento=?, nm_bairro=?, endereco=? WHERE id=?");
    $stmt->bind_param("sssssssssi", $nome, $nomeUser, $email, $telefone, $hashed_new_password, $sexo_id, $dt_nascimento, $nm_bairro, $endereco, $user_id);

    // Executa a consulta
    if ($stmt->execute()) {
        $_SESSION['profile_updated'] = true;
        // Redireciona o usuário de volta para a página de edição do perfil
        header('Location: perfil.php');
        exit;
    } else {
        echo "Erro: " . $stmt->error;
    }

    // Fecha a declaração
    $stmt->close();
    // Fecha a conexão
    $conexao->close();
}
?>


