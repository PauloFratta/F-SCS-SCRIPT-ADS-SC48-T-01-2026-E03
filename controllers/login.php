<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
session_start();


require_once __DIR__ . '/../database/connection.php';
require_once __DIR__ . '/../repository/UserRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email'] ?? '');
    $senha = $_POST['password'] ?? '';

    if ($email === '' || $senha === '') {
        header('Location: ../models/login.html?erro=1');
        exit;
    }

    $userRepo = new UserRepository();
    $usuario = $userRepo->VerificarDadosUsuario($email, $senha);

    if ($usuario) {
        $_SESSION['usuario_id']    = $usuario['id_usuario'];
        $_SESSION['usuario_email'] = $usuario['email'];
        $_SESSION['usuario_nome']  = $usuario['nome'];

        header('Location: ../models/menu.html');
        exit;
    } else {
        header('Location: ../models/login.html?erro=1');
        exit;
    }
} else {
    header('Location: ../models/login.html');
    exit;
}
?>