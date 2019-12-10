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
echo $data->nombre;
        //doy los valores al objeto mesero
        $producto->nombre = $data->nombre;
        $producto->descripcion = $data->descripcion;
        $producto->precio = $data->precio;
        $producto->id_tipo_producto = $data->id_tipo_producto;
        $producto->id_unidad_medida = $data->id_unidad_medida;
        $producto->imagen=$data->imagen;
        if($producto->crear())
        {
            http_response_code(201);
            echo json_encode(array('messsage'=>'Producto fue creado exitosamente'));
        }else
        {
            //servicio invalido
            http_response_code(201);
            echo json_encode(array('messsage'=>'Error'));
        }



?>