<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     
 
    include_once '../config/basedatos.php';
    include_once '../objects/usuario.php';

    $database = new Database();
    $db = $database->connect();
    $usuarios = new Usuarios($db);
    $data = json_decode(file_get_contents("php://input"));
    //preguntamos si los campos no estan vacios

    if( !empty($data->id) && 
        !empty($data->usuario) && 
        !empty($data->password) &&
        !empty($data->email) &&
        !empty($data->tipo_usuario) &&
        !empty($data->estado) 
      
      
    )
    {
        //doy los valores al objeto mesero
        $usuarios->usuario = $data->usuario;
        $usuarios->password = $data->password;
        $usuarios->email = $data->email;
        $usuarios->id_persona = $data->id;
        $usuarios->estado = $data->estado;
        $usuarios->tipo_usuario = $data->tipo_usuario;
        if($usuarios->crear())
        {
            http_response_code(201);
            echo json_encode(array('messsage'=>'Usuario fue creado exitosamente'));
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