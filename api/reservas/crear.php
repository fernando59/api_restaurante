<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
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
        $reserva->fecha = $data->fecha;
        $reserva->tipo_reserva = $data->tipo_reserva;
        $reserva->id_cliente = $data->id_cliente;
        $reserva->observaciones = $data->observaciones;
        $reserva->numero_personas = $data->numero_personas;
        $reserva->hora = $data->hora;
        $reserva->estado = $data->estado;
        if($reserva->crear())
        {
            http_response_code(201);
            echo json_encode(array('messsage'=>'Reserva fue creada exitosamente'));
        }else
        {
            //servicio invalido
            http_response_code(503);
            echo json_encode(array('messsage'=>'Error'));
        }
    
 

?>