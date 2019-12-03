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

      //doy los valores al objeto mesero
        $pedido->estado= $data->estado;
        $pedido->id_reserva = $data->id_reserva;
        $pedido->id_mesero = $data->id_mesero;
        $pedido->fecha = $data->fecha;
        if($pedido->crear())
        {
            http_response_code(201);
            echo json_encode(array('messsage'=>'Pedido fue creado exitosamente'));
        }else
        {
            //servicio invalido
            http_response_code(201);
            echo json_encode(array('messsage'=>'Error'));
        }
    
 


?>