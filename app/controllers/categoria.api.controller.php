<?php
require_once 'app/controllers/api.controller.php';
require_once 'app/models/categoria.api.model.php';
require_once 'app/helpers/auten.api.helper.php';


class CategoriaApiController extends ApiController{
    private $model;

    public function __construct(){
        parent::__construct();  //llamo al constructor del padre
        $this->model = new CategoriaApiModel;
    }

    public function getCategorias(){
        if(isset($_GET["field"]) && isset($_GET["value"])){
            $field = $_GET["field"];
            $value = $_GET["value"];
            $flag = false;
            $campos = $this->model->obtenerCampos(); //traigo todos los campos de la tabla categorias
            foreach($campos as $campo){
                if($field == $campo->Field){
                    $flag = true;
                }
            }
            if($flag){
                $categorias = $this->model->getCategoriasByFiltro($field, $value);
                if(empty($categorias)){
                    $this->view->response(['mensaje' =>'Ingrese correctamente los datos del filtro'], 404);
                    return;
                }
                $this->view->response($categorias, 200);
            }
            else{
                $this->view->response(['mensaje' =>'Ingrese correctamente los datos del filtro'], 404);
                return;
            }
        }
        else{
            //si no hay filtro mostramos todas las categorias
            $categorias = $this->model->getCategorias();
            $this->view->response($categorias, 200);
        }
    }

    public function getCategoria($params = []){
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

    public function deleteCategoria($params = []){
        $user = $this->autenHelper->currentUser();
        if(!$user) {
            $this->view->response('Unauthorized', 401);
            return;
        }

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
        $user = $this->autenHelper->currentUser();
        if(!$user) {
            $this->view->response('Unauthorized', 401);
            return;
        }
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
        $user = $this->autenHelper->currentUser();
        if(!$user) {
            $this->view->response('Unauthorized', 401);
            return;
        }
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