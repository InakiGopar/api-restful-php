<?php
require_once("app/controllers/producto.api.controller.php");
require_once("app/models/producto.api.model.php");
require_once("app/models/categoria.api.model.php");

class ProductoApiController extends ApiController{
    //atributos
    private $model;
    private $categoriaModel;

    //constructor
    public function __construct(){
        parent::__construct();  
        $this->model = new ProductoApiModel;
        $this->categoriaModel = new CategoriaApiModel;
    }

    //metodos
    public function getProductos(){
        if(isset($_GET["field"]) && isset($_GET["order"]) && ($_GET["order"] == 'ASC' || $_GET["order"] == 'DESC')){
            $field = $_GET["field"];
            $order = $_GET["order"];
            $flag = false;
            $campos = $this->model->obtenerCampos(); //traigo todos los campos de la tabla productos
            foreach($campos as $campo){
                if($field == $campo->Field){
                    $flag = true;
                }
            }
            if($flag){
                //obtengo los productos de la base de datos (model)
                $productos = $this->model->getProductos($field, $order);
                $this->view->response($productos, 200);
            }
            else{
                $this->view->response(['mensaje' => 'Ingrese correctamente los datos de ordenamiento'] 
                                        , 404);
            }
        }
        else{
            //si no hay query params muestra todos los productos por precio en orden ascendente
            $field = "precio";
            $order = "ASC";
            $productos = $this->model->getProductos($field, $order);
            $this->view->response($productos, 200);
        }
    }

    public function getProducto($params = []){
        $producto = $this->model->getProductoById($params[':ID']);
        //validacion
        if($producto){
            $this->view->response($producto, 200);
        }
        else{
            $this->view->response(['mensaje' => 'El producto con el id= '
                                    . $params[':ID'] . ' no existe.'] , 404);
        }
    }

    public function deleteProducto($params = []){
        $id = $params[':ID'];
        $producto = $this->model->getProductoById($id);
        //validacion
        if($producto){
            $this->model->eliminarProducto($id);
            $this->view->response(['mensaje'=>'El producto con el id= ' .
                                    $id .' fue borrado con exito'], 200);
        }
        else{
            $this->view->response(['mensaje' => 'El producto con el id= '
                                    . $id .' no existe'], 404);
        }
    }

    public function addProducto(){
        //obtenemos el body que nos manda el cliente de la api
        $body = $this->getData(); //desarma el JSON y nos genera un objeto  

        $id_categoria = $body->id_categoria; //Traer el productoByCategoria nos ahorramos de try catch
        $nombre = $body->nombre;
        $material = $body->material;
        $color = $body->color;
        $precio = $body->precio; 

        try{
            //pedimos al model que nos agregue ese producto
            $id = $this->model->agregarProducto($id_categoria, $nombre, $material, $color, $precio);
            $this->view->response(['mensaje' => 'El producto con el id= '
                                    . $id .' fue insertado exitosamente'], 201);
        }catch(Exception){ //Manejamos la excepcion de que una categoria tenga productos cargados
            $this->view->response(['mensaje' => 'No se puede agregar el producto ingrese un id_categoria valido'],
                                    403);
        }
    }

    public function actualizarProducto($params = []){
        //capturo el id
        $id = $params[':ID'];
        //me traigo el producto
        $producto = $this->model->getProductoById($id);

        if($producto){
            $body = $this->getData();  

            $id_categoria = $body->id_categoria;
            $nombre = $body->nombre;
            $material = $body->material;
            $color = $body->color;
            $precio = $body->precio; 

            try{
            $this->model->modificarProducto($id, $id_categoria, $nombre, $material, $color, $precio);
            $this->view->response(['mensaje' => 'El producto con el id= '
                                    . $id .' ha sido modificado exitosamente'], 200);
            }
            catch(Exception){
                $this->view->response(['mensaje'=>'No es posible actualizar el producto con el id= ' 
                                        . $id .' ingrese un id_categoria existente '], 403); //DUDA
            }
        }
        else{
            $this->view->response(['mensaje' => 'El producto con el id= '
                                    . $id .' no existe'], 404);
        }

    }

    

    
}