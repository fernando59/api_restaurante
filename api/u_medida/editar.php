<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     
 
    include_once '../config/basedatos.php';
    include_once '../objects/u_medida.php';

    $database = new Database();
    $db = $database->connect();
    $u_medida = new U_Medida($db);

    $data = json_decode(file_get_contents("php://input"));

    //preguntamos si los campos no estan vacios

    if( !empty($data->codigo) && 
        !empty($data->nombre)
     
    )
    {
        //doy los valores al objeto mesero
        $u_medida->codigo = $data->codigo;
        $u_medida->nombre = $data->nombre;
        if($u_medida->editar())
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