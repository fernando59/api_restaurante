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

    if( !empty($data->codigo) && 
        !empty($data->nombre_usuario) && 
        !empty($data->password_usuario) &&
        !empty($data->email) &&
        !empty($data->codigo_usuario) &&
        !empty($data->estado) 
      
      
    )
    {
        //doy los valores al objeto mesero
        $usuarios->nombre_usuario = $data->nombre_usuario;
        $usuarios->password_usuario = $data->password_usuario;
        $usuarios->email = $data->email;
        $usuarios->codigo = $data->codigo;
        $usuarios->estado = $data->estado;
        $usuarios->codigo_usuario = $data->codigo_usuario;
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
        http_response_code(201);
        echo json_encode(array('messsage'=>'Error'));
    }


?>