<?php
class Noticias {
    private $conn;
    private $table_name = "noticias";


    public function __construct($db) {
        $this->conn = $db;
    }
    public function criar($id_usu,$data,$titulo,$noticia) {
        $query = "INSERT INTO " . $this->table_name . " (id_usu, data, titulo, noticia) VALUES (?, ?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_usu,$data,$titulo,$noticia]);
        return $stmt;
    }

    public function ler() { 
        $query = "SELECT * FROM " . $this->table_name; 
        $stmt = $this->conn->prepare($query); 
        $stmt->execute(); 
        return $stmt; 
    } 
    public function lerPorId($id_usu) {
        $query = "SELECT * FROM " . $this->table_name . " WHERE id_usu = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_usu]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function deletar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?"; 
        $stmt = $this->conn->prepare($query); 
        $stmt->execute([$id]); 
        return $stmt; 
    }
}
?>
