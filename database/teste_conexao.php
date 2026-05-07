<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);

require __DIR__ . '/connection.php';

try {
    $conn = Database::connect();

    $result = $conn->query("SELECT VERSION()");
    $version = $result->fetchColumn();

    echo "✅ Banco conectado! Versão do MySQL: " . $version;

} catch (Exception $e) {
    echo "❌ Erro: " . $e->getMessage();
}