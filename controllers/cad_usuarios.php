<?php
session_start();

require_once __DIR__ . '/../database/connection.php';
require_once __DIR__ . '/../repository/UserRepository.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nome            = trim($_POST['nome'] ?? '');
    $email           = trim($_POST['email'] ?? '');
    $confirmar_email = trim($_POST['confirmar_email'] ?? '');
    $senha           = $_POST['senha'] ?? '';

    // Validação de campos vazios
    if ($nome === '' || $email === '' || $confirmar_email === '' || $senha === '') {
        header('Location: ../models/cad_usuarios.html?erro=campos');
        exit;
    }

    // Validação de e-mails iguais
    if ($email !== $confirmar_email) {
        header('Location: ../models/cad_usuarios.html?erro=email');
        exit;
    }

    $userRepo = new UserRepository();
    $cadastrado = $userRepo->CadastrarUsuario($nome, $email, $senha);

    if ($cadastrado) {
        header('Location: ../models/login.php?sucesso=1');
        exit;
    } else {
        header('Location: ../models/cad_usuarios.html?erro=existe');
        exit;
    }

} else {
    header('Location: ../models/cad_usuarios.html');
    exit;
}
?>