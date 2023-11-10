<?php
require_once 'database/config.php';
require_once 'app/models/model.php';

class UsuarioModel extends Model{

    public function obtenerNombre($nombre){
        $query = $this->db->prepare("SELECT * FROM usuarios WHERE nombre = ?");
        $query->execute([$nombre]);

        return $query->fetch(PDO::FETCH_OBJ);
    }
}