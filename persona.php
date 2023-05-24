<?php
require_once 'public/respuestas.class.php';
require_once 'public/persona.class.php';

$_respuestas = new respuestas;
$_persona = new persona;

// header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: X-API-KEY, Origin, X-Requested-With, Content-Type, Accept, Access-Control-Request-Method");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Allow: GET, POST, OPTIONS, PUT, DELETE");


if($_SERVER['REQUEST_METHOD'] == "GET"){
    //echo "hola get";
    $id = $_GET['id'];

    if(!$id){
        $totalPersonas = $_persona->totalPersonas();
        $listaPersona = $_persona->listaPersona();
        header("Content-Type: application/json");
        echo json_encode($listaPersona);
        http_response_code(200);
    }else{
        $datosPersona = $_persona->obtenerPersona($id);
        $persona = $datosPersona ? $datosPersona[0] : []; 
        header("Content-Type: application/json");
        echo json_encode($persona);
        http_response_code(200);
    }

}else if($_SERVER['REQUEST_METHOD'] == "POST"){
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos los datos al manejador
    $datosArray = $_persona->post($postBody);
    //devolvemos la respuesta
    header("Content-Type: application/json");
    if(isset($datosArray["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode($datosArray["result"]);

}else if($_SERVER['REQUEST_METHOD'] == "PUT"){
    $id = $_GET["id"];
    //echo "hola put";
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos datos al manejador
    $datosArray = $_persona->put($postBody, $id);
    //print_r($postBody);
    //devolvemos la respuesta
    header("Content-Type: application/json");
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode("la Persona fue actualziado correctamente");

}else if($_SERVER['REQUEST_METHOD'] == "DELETE"){
    $id = $_GET["id"];
    //recibimos los datos enviados
    $postBody = file_get_contents("php://input");
    //enviamos datos al manejador
    $datosArray = $_persona->delete($id);
    //print_r($postBody);
    //devolvemos la respuesta
    header("Content-Type: application/json");
    if(isset($datosArray["result"]["error_id"])){
        $responseCode = $datosArray["result"]["error_id"];
        http_response_code($responseCode);
    }else{
        http_response_code(200);
    }
    echo json_encode("La Persona fue borrada correctamente");
}else{
    header('Content-Type: application/json');
    $datosArray = $_respuestas->error_405();
    echo json_encode($datosArray);
}
