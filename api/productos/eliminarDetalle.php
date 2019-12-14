<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods:  DELETE");
    header("Access-Control-Max-Age: 3600");
    header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
     
 
    include_once '../config/basedatos.php';
    include_once '../objects/productos.php';

    $database = new Database();
    $db = $database->connect();
    $producto = new Producto($db);
    $data = json_decode(file_get_contents("php://input"));
    //preguntamos si los campos no estan vacios

      $producto->id_pedido = $data->id_pedido;
      $producto->id_producto = $data->id_producto;
     $producto->cantidad = $data->cantidad;
            $producto->precio = $data->precio;
        if($producto->eliminarDetalle())
        {
            http_response_code(200);
            echo json_encode(array('messsage'=>'Detalle fue eliminado'));
        }else
        {
            //servicio invalido
            http_response_code(200);
            echo json_encode(array('messsage'=>'Error'));
        }



?>