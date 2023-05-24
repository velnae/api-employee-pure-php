<?php
require_once 'conexion/conexion.php';
require_once 'respuestas.class.php';

class persona extends conexion{
    private $table = "persona";
    private $personaid = ""; //id 
    private $nombre = ""; //
    private $apellido = ""; //
    private $fechanacimiento = "0000-00-00"; //
    private $dni = ""; //
    

    //lista todas las personas con paginacion de 1 a 5
    public function listaPersona($pagina = 1){
        $cantidad = 5;
        $inicio = ($pagina - 1) * $cantidad;

        $query = "SELECT ID, nombre, apellido, fechanacimiento, dni FROM " . $this->table . " LIMIT $inicio, $cantidad";
        $datos = parent::obtenerDatos($query);
        
        return $datos;
        //
    }

    //muestra los datos de una sola persona
    public function obtenerPersona($id){
        $query = "SELECT * FROM " . $this->table . " WHERE ID = '$id'";
        //print_r($query);
        //$datos = parent::obtenerDatos($query);
        return parent::obtenerDatos($query);
    }

    //
    public function post($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['nombre']) || !isset($datos['apellido']) || !isset($datos['fechanacimiento']) || !isset($datos['dni'])){
            return $_respuestas->error_400();
        }else{
            $this->nombre=$datos['nombre'];
            $this->apellido=$datos['apellido'];
            $this->fechanacimiento=$datos['fechanacimiento'];
            $this->dni=$datos['dni'];
            $resp = $this->insertarPersona();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "personaid" => $resp
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }
    }

    ///para insertar persona
    private function insertarPersona(){
        $query = "INSERT INTO " . $this->table . " (nombre, apellido, fechanacimiento, dni)
        values
        ('" . $this->nombre . "','" . $this->apellido . "','" . $this->fechanacimiento . "','" . $this->dni . "')";
        //print_r($query);
        $resp = parent::nonQueryId($query);
        if($resp){
            return $resp;
        }else{
            return 0;
        }
    }

    //para el metodo put
    public function put($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['ID'])){
            return $_respuestas->error_400();
        }else{
            $this->personaid = $datos['ID'];
            if(isset($datos['nombre'])){$this->nombre=$datos['nombre'];}
            if(isset($datos['apellido'])){$this->apellido=$datos['apellido'];}
            if(isset($datos['fechanacimiento'])){$this->fechanacimiento=$datos['fechanacimiento'];}
            if(isset($datos['dni'])){$this->dni=$datos['dni'];}      
            
            $resp = $this->modificarPersona();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "personaid" => $this->personaid
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }

    }

    ///para insertar persona
    private function modificarPersona(){
        $query = "UPDATE " . $this->table . " SET nombre = '" . $this->nombre . "', apellido = '" . $this->apellido . "', fechanacimiento = '" . $this->fechanacimiento . "', dni = '" . 
        $this->dni . "'WHERE ID = '" . $this->personaid . "'";
                
        //print_r($query);
        $resp = parent::nonQuery($query);
        if($resp>=1){
            return $resp;
        }else{
            return 0;
        }
    }

    ///para eliminar persona
    public function delete($json){
        $_respuestas = new respuestas;
        $datos = json_decode($json,true);
        if(!isset($datos['ID'])){
            return $_respuestas->error_400();
        }else{
            $this->personaid = $datos['ID'];
            
            $resp = $this->elinimarPersona();
            if($resp){
                $respuesta = $_respuestas->response;
                $respuesta["result"] = array(
                    "personaid" => $this->personaid
                );
                return $respuesta;
            }else{
                return $_respuestas->error_500();
            }
        }
    }

    private function elinimarPersona(){
        $query = "DELETE FROM " . $this->table . " WHERE ID= '" . $this->personaid . "'";
        $resp = parent::nonQuery($query);
        if($resp >= 1){
            return $resp;
        }else{
            return 0;
        }
    }

}



?>