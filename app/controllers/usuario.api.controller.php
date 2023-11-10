<?php 
    require_once 'app/controllers/api.controller.php';
    require_once 'app/helpers/auten.api.helper.php';
    require_once 'app/models/usuario.api.model.php';
    
    class UsuarioApiController extends ApiController {
        private $model;
        private $autenHelper;
    
        public function construct(){
            parent::__construct(); //llamo la constructor del padre
            $this->model = new UsuarioModel();
            $this->autenHelper = new AutenHelper();
        }
    
        public function getToken($params = []){
            $basic = $this->autenHelper->getAutenHeaders(); // Darnos el header 'Authorization:' 'Basic: base64(usr:pass)'
    
            if(empty($basic)){  //me aseguro que el basic no este vacio
                $this->view->response(['mensaje' => 'No envio encabezados de 
                autenticacion'] , 401);
                return;
            }
    
            $basic = explode(" ", $basic);  // ["Basic", "base64(usr:pass)"]
    
            if($basic[0] != "Basic"){
                $this->view->response(['mensaje' => 'Los  encabezados de 
                autenticacion son incorrectos'] , 401);
            }
    
            $userpass = base64_decode($basic[1]); // usr:pass
            $userpass = explode(":", $userpass);  // ["usr", "pass"]
    
            $user = $userpass[0];
            $pass = $userpass[1];
    
            //Duda **¿
    
            $userData = ["nombre" => $user];
    
            $usuario = $this->model-> obtenerNombre($user);
    
            if($user == $usuario->nombre && password_verify($pass, $usuario->password)){
                $token = $this->autenHelper->createToken($userData);
                $this->view->response($token);
            }
            else{
                $this->view->response('El usuario o contraseña son incorrectos' , 401);
            }
    
            //Fin de duda ***?
        }
    }