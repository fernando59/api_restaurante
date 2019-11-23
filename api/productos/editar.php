<?php 
    header("Access-Control-Allow-Origin: *");
    header("Content-Type: application/json; charset=UTF-8");
    header("Access-Control-Allow-Methods: PUT");
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
        $producto->codigo=$data->codigo;
        $producto->nombre = $data->nombre;
        $producto->descripcion = $data->descripcion;
        $producto->sw_stock = $data->sw_stock;
        $producto->precio = $data->precio;
        $producto->tipo_producto = $data->tipo_producto;
        $producto->id_unidad_medida = $data->id_unidad_medida;

        if($producto->editar())
        {
            http_response_code(201);
            echo json_encode(array('messsage'=>'Producto fue editado exitosamente'));
        }else
        {
            //servicio invalido
            http_response_code(503);
            echo json_encode(array('messsage'=>'Error'));
        }
    
    


?>