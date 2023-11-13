<?php 
    require_once 'app/controllers/api.controller.php';
    require_once 'app/helpers/auten.api.helper.php';
    require_once 'app/models/usuario.api.model.php';
    
    class UsuarioApiController extends ApiController {
        private $model;
    
        public function __construct(){
            parent::__construct(); //llamo la constructor del padre
            $this->model = new UsuarioModel;
        }
    
        public function getToken($params = []){
            $basic = $this->autenHelper->getAutenHeaders(); // Darnos el header 'Authorization:' 'Basic: base64(usr:pass)'

            if (empty($basic)) {
                $this->view->response('No envió encabezados de autenticación.', 401);
                return;
            }
            
            $basic = explode(" ", $basic); // ["Basic", "base64(usr:pass)"] 
        
            if ($basic[0] != "Basic") {
                $this->view->response('Los encabezados de autenticación son incorrectos.', 401);
                return;
            }
        
            $userpass = base64_decode($basic[1]); // usr:pass
            $userpass = explode(":", $userpass); // ["usr", "pass"]
    
            $nombre = $userpass[0];
            $password = $userpass[1];

            $user = $this->model->obtenerNombre($nombre);
            
            if (!empty($user)){
                if (password_verify($password, $user->password)){
                    $userdata = ["id_usuario" => $user->id_usuario, "nombre" => $user->nombre];
                    $token = $this->autenHelper->createToken($userdata);
                    $this->view->response($token, 200);
                    return;
                }
            }
            $this->view->response('El usuario o contraseña son incorrectos.', 401);
        }
    }
