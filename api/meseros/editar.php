<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     
 
    include_once '../config/basedatos.php';
    include_once '../objects/mesero.php';

    $database = new Database();
    $db = $database->connect();
    $mesero = new Mesero($db);

    $data = json_decode(file_get_contents("php://input"));

    //preguntamos si los campos no estan vacios

    if( !empty($data->nombre) && 
        !empty($data->apellido) && 
        !empty($data->edad) && 
        !empty($data->direccion) && 
        !empty($data->ci) && 
        !empty($data->telefono) &&
        !empty($data->id) 
    )
    {
        //doy los valores al objeto mesero
        $mesero->nombre = $data->nombre;
        $mesero->apellido = $data->apellido;
        $mesero->edad = $data->edad;
        $mesero->direccion = $data->direccion;
        $mesero->telefono = $data->telefono;
        $mesero->ci = $data->ci;
        $mesero->id = $data->id;
        if($mesero->editar())
        {
            http_response_code(201);
            echo json_encode(array('messsage'=>'Mesero fue modificado exitosamente'));
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