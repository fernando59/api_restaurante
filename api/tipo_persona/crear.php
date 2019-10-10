<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     
 
    include_once '../config/basedatos.php';
    include_once '../objects/tipo_persona.php';

    $database = new Database();
    $db = $database->connect();
    $mesa = new Mesas($db);

    $data = json_decode(file_get_contents("php://input"));

    //preguntamos si los campos no estan vacios

    if( !empty($data->nombre) && 
        !empty($data->estado) && 
        !empty($data->capacidad) 
      
    )
    {
        //doy los valores al objeto mesero
        $mesa->nombre = $data->nombre;
        $mesa->estado = $data->estado;
        $mesa->capacidad = $data->capacidad;
        if($mesa->crear())
        {
            http_response_code(201);
            echo json_encode(array('messsage'=>'Mesa fue creada exitosamente'));
        }else
        {
            //servicio invalido
            http_response_code(503);
            echo json_encode(array('messsage'=>'Error'));
        }
    }
     else
    {
        http_response_code(404);
        echo json_encode(array('messsage'=>'Error'));
    }


?>