<?php
class Usuario {
    private $conn;
    private $table_name = "usuarios";

    public function __construct($db) {
        $this->conn = $db;
    }

    public function registrar($nome, $sexo, $fone, $email, $senha) {
        $query = "INSERT INTO " . $this->table_name . " (nome, sexo, fone, email, senha) values (?, ?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $hashed_password = password_hash($senha, PASSWORD_BCRYPT);
        $stmt->execute([$nome, $sexo, $fone, $email, $hashed_password]);
        return $stmt;
    }

    public function login($email, $senha) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE email =
        ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$email]);
        $usuario = $stmt->fetch(PDO::FETCH_ASSOC);
        if ($usuario && password_verify($senha, $usuario['senha'])) {
            return $usuario;
    }
    return false;
    }

    public function criar($nome, $sexo, $fone,$email, $senha){
        return $this->registrar($nome,$sexo, $fone, $email, $senha);
    }
}