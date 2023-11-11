<?php
require_once 'app/controllers/api.controller.php';
require_once 'app/models/categoria.api.model.php';


class CategoriaApiController extends ApiController{
    private $model;

    public function __construct(){
        parent::__construct();  //llamo al constructor del padre
        $this->model = new CategoriaApiModel;
    }


    public function getCategorias($params = []){
        //Si el parametro esta vacio
        if(empty($params)){
            //obtengo las categorias de la base de datos (model)
            $categorias = $this->model->getCategorias();
            $this->view->response($categorias, 200);
        }
        //Si no esta vacio obtengo esa categoria pasada por parametro
        else{
            $categoria = $this->model->getCategoriaById($params[':ID']);
            //validacion
            if($categoria){
                $this->view->response($categoria, 200);
            }
            else{
                $this->view->response(['mensaje' => 'La categoria con el id= '
                                        . $params[':ID'] . ' no existe.'] , 404);
            }
        }
        
    }

    public function deleteCategoria($params = []){
        $id = $params[':ID'];
        $categoria = $this->model->getCategoriaById($id);
        //validacion
        if($categoria){
            try{
                $this->model->eliminarCategoria($id);
                $this->view->response(['mensaje'=>'La categoria con el id= ' .
                                        $id .' fue borrada con exito'], 200);
            }
            catch(Exception){ //Manejamos la excepcion de que una categoria tenga productos cargados
                $this->view->response(['mensaje'=>'No es posible eliminar la categoria con el id= ' .
                                        $id .' debido a que tiene productos cargados'], 400); 
            }
        }
        else{
            $this->view->response(['mensaje' => 'La categoria con el id= '
                                    . $id .' no existe'], 404);
        }
    }

    public function addCategoria(){
        //obtenemos el body que nos manda el cliente de la api
        $body = $this->getData(); //desarma el JSON y nos genera un objeto  
        $categoria = $body->categoria;
        $fragil = $body->fragil;

        //pedimos al model que nos agregue esa categoria
        $id = $this->model->agregarCategoria($categoria, $fragil);
        
        $this->view->response(['mensaje' => 'La categoria con el id= '
        . $id .' fue insertada exitosamente'], 201);
    }

    public function actualizarCategoria($params = []){
        //capturo el id
        $id = $params[':ID'];
        //me traigo la categoria
        $categoria = $this->model->getCategoriaById($id);

        if($categoria){
            $body = $this->getData();   
            $categoria = $body->categoria;
            $fragil = $body->fragil;

            $this->model->modificarCategoria($id, $categoria, $fragil);
            $this->view->response(['mensaje' => 'La categoria con el id= '
            . $id .' ha sido modificada exitosamente'], 200);
        }
        else{
            $this->view->response(['mensaje' => 'La categoria con el id= '
            . $id .' no existe'], 404);
        }

    }
}