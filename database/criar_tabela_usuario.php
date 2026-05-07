<?php
// criar_banco.php - DELETAR APÓS USO!

$host   = 'sql209.infinityfree.com';
$user   = 'if0_41832603';   // usuário MySQL do painel 42web
$pass   = 'HvA4Oy8lRP4U';     // senha MySQL do painel 42web
$dbname = 'if0_41832603_ecomapa';     // nome do banco do painel 42web

try {
    $pdo = new PDO("mysql:host=$host;charset=utf8", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $pdo->exec("CREATE DATABASE IF NOT EXISTS `$dbname`");
    $pdo->exec("USE `$dbname`");

    $pdo->exec("CREATE TABLE IF NOT EXISTS usuarios (
        id_usuario INT AUTO_INCREMENT PRIMARY KEY,
        nome       VARCHAR(100) NOT NULL,
        email      VARCHAR(100) NOT NULL UNIQUE,
        senha      VARCHAR(100) NOT NULL,
        tipo       VARCHAR(20)  NOT NULL DEFAULT 'usuario'
    )");

    $pdo->exec("INSERT IGNORE INTO usuarios (nome, email, senha, tipo) VALUES
        ('Andre',    'andre@a',    '1234', 'usuario'),
        ('Ricardo',  'ricardo@r',  '1234', 'usuario'),
        ('Carlos',   'carlos@c',   '1234', 'admin'),
        ('Gabriela', 'gabriela@g', '1234', 'usuario')
    ");

    echo "✅ Banco criado e dados inseridos com sucesso!";

} catch (PDOException $e) {
    echo "❌ Erro: " . $e->getMessage();
}
?>