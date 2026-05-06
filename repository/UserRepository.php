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
}