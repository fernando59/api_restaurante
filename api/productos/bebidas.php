<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');

    include_once '../objects/productos.php';
    include_once '../config/basedatos.php';

    $database =  new  Database();
    $db = $database->connect();

    $productos = new Producto($db);
    $resultado  =$productos->mostrarBebidas();
    $numero  = $resultado->rowCount();

    if($numero>0)
    {
        $array_productos=array();
        $array_productos['data']=array();
        while($fila = $resultado->fetch(PDO::FETCH_ASSOC))
        {
            extract($fila);
            //Creo una v  ariable con el array y paso los parametros
            $item  =array(
                'codigo'=>$codigo,
                'nombre'=>$nombre,
                'descripcion'=>$descripcion,
                'precio'=>$precio,
                'producto'=>$producto,
                'unidad_de_medida'=>$unidad,
                'id_unidad_medida'=>$id_unidad_medida,
                'imagen'=>base64_encode($imagen),
                'id_tipo_producto'=>$id_tipo_producto
            );
            http_response_code(200);
            array_push($array_productos['data'],$item);


           

         }
         echo json_encode($array_productos);

    }else
    {
        http_response_code(404);
        echo json_encode(array("message" =>"error"));
    }


?>