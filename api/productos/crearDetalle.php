<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: POST");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     
 
    include_once '../config/basedatos.php';
    include_once '../objects/productos.php';

    $database = new Database();
    $db = $database->connect();
    $producto = new Producto($db);

    $data = json_decode(file_get_contents("php://input"));

    //preguntamos si los campos no estan vacios

        //doy los valores al objeto mesero
        $producto->id_pedido = $data->id_pedido;
        $producto->id_producto = $data->id_producto;
        $producto->cantidad = $data->cantidad;
        $producto->precio = $data->precio;
        
        if($producto->crearDetalle())
        {
            http_response_code(201);
            echo json_encode(array('messsage'=>'Detalle pedido fue creada exitosamente'));
        }else
        {
            //servicio invalido
            http_response_code(201);
            echo json_encode(array('messsage'=>'Error'));
        }
    
 

?>