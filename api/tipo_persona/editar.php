<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     
 
    include_once '../config/basedatos.php';
    include_once '../objects/Tipo_Persona.php';

    $database = new Database();
    $db = $database->connect();
    $tipo_persona = new Tipo_Persona($db);

    $data = json_decode(file_get_contents("php://input"));

    //preguntamos si los campos no estan vacios

    if( !empty($data->id) && 
        !empty($data->descripcion)
     
    )
    {
        //doy los valores al objeto mesero
        $tipo_persona->descripcion = $data->descripcion;
        $tipo_persona->id = $data->id;
        if($tipo_persona->editar())
        {
            http_response_code(201);
            echo json_encode(array('messsage'=>'Fue modificado exitosamente'));
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