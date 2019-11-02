<?php 
     header("Access-Control-Allow-Origin: *");
     header("Content-Type: application/json; charset=UTF-8");
     header("Access-Control-Allow-Methods: DELETE");
     header("Access-Control-Max-Age: 3600");
     header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

     include_once '../config/basedatos.php';
     include_once '../objects/u_medida.php';

     $database = new Database();
     $db = $database->connect();
     $u_medida = new U_Medida($db);
   
     $data = json_decode(file_get_contents("php://input"));
     $id = isset($_GET['id'])?$_GET['id']:'';
     //$mesa->id = $data->id;
     if($u_medida->eliminar($id))
     {
         http_response_code(200);
         echo json_encode(array('messsage'=>'Mesa fue eliminada exitosamente'));
     }else
     {
         //servicio invalido
         http_response_code(503);
         echo json_encode(array('messsage'=>'Error'));
     }


?>