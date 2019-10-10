<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    //header("Access-Control-Max-Age: 3600");
    //header('Access-Control-Allow-Headers:Access-Control-Allow-Headers,Content-Type,Access-Control-Allow-Methods,Authorization,X-Requested-With');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");  
 
    include_once '../config/basedatos.php';
    include_once '../objects/pedidos.php';

    $database = new Database();
    $db = $database->connect();
    $pedido = new Pedidos($db);

    $data = json_decode(file_get_contents("php://input"));


    //preguntamos si los campos no estan vacios

    if( !empty($data->descripcion) && 
        !empty($data->id_mesa) && 
        !empty($data->id_mesero) 
      
    )
    {
        //doy los valores al objeto mesero
        $pedido->descripcion = $data->descripcion;
        $pedido->id_mesa = $data->id_mesa;
        $pedido->id_mesero = $data->id_mesero;
        if($pedido->crear())
        {
            http_response_code(201);
            echo json_encode(array('messsage'=>'Pedido fue creado exitosamente'));
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