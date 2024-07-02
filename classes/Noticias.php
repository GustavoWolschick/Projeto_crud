<?php
class Noticia {
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

    public function ler($search = '') {
        $query = "SELECT * FROM " . $this->table_name;
        $conditions = [];
        $params = [];

        if ($search) {
           $conditions[] = " (titulo LIKE :search OR noticia LIKE :search)";
            $params[':search'] = '%' . $search . '%';
        }

        if (count($conditions) > 0) {
            $query .= " WHERE " . implode(' AND ', $conditions );
        }else{
            $query .= " ORDER BY id DESC";
        }

        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);
        return $stmt;
    }
    public function lerPorId($id_usu) {

        $query = "SELECT * FROM " . $this->table_name . " WHERE id_usu = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id_usu]); 
        return $stmt;
    }

    public function lerPorIdNoticia($id) {

        $query = "SELECT * FROM " . $this->table_name . " WHERE id = ?";
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function atualizar($titulo, $noticia, $id) {
        $query = "UPDATE " . $this->table_name . " SET titulo = ?, noticia = ? WHERE id = ?"; 
        $stmt = $this->conn->prepare($query);
        $stmt->execute([$titulo, $noticia, $id]);
        return $stmt; 
    }

    public function deletar($id) {
        $query = "DELETE FROM " . $this->table_name . " WHERE id = ?"; 
        $stmt = $this->conn->prepare($query); 
        $stmt->execute([$id]); 
        return $stmt; 
    }
}
?>
