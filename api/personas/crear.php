<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     
 
    include_once '../config/basedatos.php';
    include_once '../objects/persona.php';

    $database = new Database();
    $db = $database->connect();
    $persona = new Personas($db);

    $data = json_decode(file_get_contents("php://input"));

    //preguntamos si los campos no estan vacios

    if( !empty($data->nombre) && 
        !empty($data->apellido) && 
        !empty($data->edad) && 
        !empty($data->direccion) && 
        !empty($data->ci) && 
        !empty($data->telefono) &&
        !empty($data->tipo_persona)
    )
    {
        //doy los valores al objeto mesero
        $persona->nombre = $data->nombre;
        $persona->apellido = $data->apellido;
        $persona->edad = $data->edad;
        $persona->direccion = $data->direccion;
        $persona->telefono = $data->telefono;
        $persona->ci = $data->ci;
        $persona->tipo_persona=$data->tipo_persona;
        if($persona->crear())
        {
            http_response_code(201);
            echo json_encode(array('messsage'=>'Mesero fue creado exitosamente'));
        }else
        {
            //servicio invalido
            http_response_code(503);
            echo json_encode(array('messsage'=>'Error'));
        }
    }
     else
    {
        http_response_code(201);
        echo json_encode(array('messsage'=>'Error'));
    }


?>