<?php
//incluyo el config.php el cual se encarga de la conexion a la db
require_once 'database/config.php';
require_once 'app/models/model.php';

class CategoriaApiModel extends Model{
    //obtiene y devuelve de la base de datos todas las categorias.
    public function getCategorias(){
        //envio la consulta
        $query = $this->db->prepare("SELECT * FROM categorias ORDER BY categoria");
        $query->execute();
        //$categorias es un arreglo de categorias
        $categorias = $query->fetchAll(PDO::FETCH_OBJ);

        return $categorias;
    }

    //obtiene la categoria pasada por id
    public function getCategoriaById($id){
        $query = $this->db->prepare("SELECT * FROM categorias WHERE id_categoria = ?");
        $query->execute([$id]);
        $categoria = $query->fetch(PDO::FETCH_OBJ);

        return $categoria;
    }

    //inserta la categoria en la base de datos
    public function agregarCategoria($categoria, $fragil){
        //blindeo(Protego) los parametreos con VALUES(?,?) (seguridad)
        $query = $this->db->prepare("INSERT INTO categorias (categoria,fragil)VALUES(?,?)");
        $query->execute([$categoria,$fragil]);
    
        return $this->db->lastInsertId();
    }


    //elimina una categoria de la base de datos
    public function eliminarCategoria($id){
        $query = $this->db->prepare("DELETE FROM categorias WHERE id_categoria = ?");
        $query->execute([$id]);
    }

    //edita el atributo fragil de la base de datos
    public function modificarCategoria($id, $categoria, $fragil){
        $query = $this->db->prepare("UPDATE categorias SET categoria = ?, fragil = ? WHERE id_categoria = ?");
        $query->execute([$categoria, $fragil,$id]);
    }
}