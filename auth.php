<?php
require_once 'public/auth.class.php';
require_once 'public/respuestas.class.php';

//$_auth = new auth;
$_respuestas = new respuestas;

if($_SERVER['REQUEST_METHOD'] == "POST"){

    $postBody = file_get_contents("php://input");
    //$_POST = file_get_contents("php://input");
    //$postBody = "hola no funciona";
    print_r($postBody);
    
}else{
    echo "metodo no permitido";
}



?>