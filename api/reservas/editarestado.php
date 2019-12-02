<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     
 
    include_once '../config/basedatos.php';
    include_once '../objects/reservas.php';

    $database = new Database();
    $db = $database->connect();
    $reserva = new Reserva($db);

    $data = json_decode(file_get_contents("php://input"));

    //preguntamos si los campos no estan vacios

        //doy los valores al objeto mesero
   
        $reserva->codigo = $data->codigo;
        $reserva->estado = $data->estado;
        if($reserva->editarEstado())
        {
            http_response_code(200);
            echo json_encode(array('messsage'=>'Estado fue editado exitosamente'));
        }else
        {
            //servicio invalido
            http_response_code(200);
            echo json_encode(array('messsage'=>'Error'));
        }
    
 

?>