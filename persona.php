<?php
require_once 'public/respuestas.class.php';
require_once 'public/persona.class.php';

$_respuestas = new respuestas;
$_persona = new persona;

if($_SERVER['REQUEST_METHOD'] == "GET"){
    //echo "hola get";

    if(isset($_GET["page"])){
        $pagina = $_GET["page"];
        $size = $_GET["size"];
        
        $totalPersonas = $_persona->totalPersonas();
        $listaPersona = $_persona->listaPersona($pagina, $size);
        $response = [
            "totalItems" => $totalPersonas,
            "totalPages" => intval($totalPersonas / 5),
            "currentPage" => $pagina,
            "persons" => $listaPersona
        ];

        header("Content-Type: application/json");
        echo json_encode($response);
        http_response_code(200);
    }else if(isset($_GET['id'])){
        $_personaid = $_GET['id'];
        $datosPersona = $_persona->obtenerPersona($_personaid);
        header("Content-Type: application/json");
        echo json_encode($datosPersona);
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


?>