<?php 
     header("Access-Control-Allow-Origin: *");
     header("Content-Type: application/json; charset=UTF-8");
     header("Access-Control-Allow-Methods: DELETE");
     header("Access-Control-Max-Age: 3600");
     header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

     include_once '../config/basedatos.php';
     include_once '../objects/mesas.php';

     $database = new Database();
     $db = $database->connect();
     $mesa = new Mesas($db);
   
     $data = json_decode(file_get_contents("php://input"));
     $mesa->id = $data->id;
     if($mesa->eliminar())
     {
         http_response_code(201);
         echo json_encode(array('messsage'=>'Mesa fue eliminada exitosamente'));
     }else
     {
         //servicio invalido
         http_response_code(503);
         echo json_encode(array('messsage'=>'Error'));
     }


?>