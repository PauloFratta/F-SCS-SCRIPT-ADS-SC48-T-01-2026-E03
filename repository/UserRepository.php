<?php
require_once __DIR__ . '/../database/connection.php';
class UserRepository {
    private $db;

    public function __construct() {
        $this->db = Database::connect();
    }
    
    public function VerificarDadosUsuario($email,$senha){
        $stmt = $this->db->prepare("SELECT * FROM usuarios where email = ? and senha = ? and tipo = 'usuario'");
        $stmt->execute([$email,$senha]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    public function CadastrarUsuario($nome, $email, $senha) {
        try {
            $stmt = $this->db->prepare("INSERT INTO usuarios (nome, email, senha, tipo) VALUES (?, ?, ?, 'usuario')");
            $stmt->execute([$nome, $email, $senha]);
            return true;
        } catch (PDOException $e) {
            return false; // e-mail duplicado ou outro erro
        }
    }    
}