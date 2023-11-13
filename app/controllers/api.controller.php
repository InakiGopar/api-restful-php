<?php
require_once 'app/views/api.view.php';
abstract class ApiController {
    protected $view;
    private $data;
    protected $autenHelper;

    public function __construct(){
        $this->view = new ApiView();
        // file_get_contents('php://input') permite leer la entrada enviada en formato RAW
        $this->data = file_get_contents('php://input');
        $this->autenHelper = new AutenHelper;
    }

    public function getData(){
        //json_decode devuelve un objeto JSON
        return json_decode($this->data);
    }
}