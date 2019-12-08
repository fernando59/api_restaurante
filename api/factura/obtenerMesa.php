<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');
    header("Access-Control-Allow-Methods:GET");
    include_once '../objects/factura.php';
    include_once '../config/basedatos.php';

    $database =  new  Database();
    $db = $database->connect();

    $pedido = new Factura($db);
    $palabra = isset($_GET['s'])?$_GET['s']:'';
    $resultado  =$pedido->mostrarMesas($palabra);
    $numero  = $resultado->rowCount();
    


    if($numero>0)
    {
        $array_pedido=array();
        $array_pedido['data']=array();
        while($fila = $resultado->fetch(PDO::FETCH_ASSOC))
        {
            extract($fila);
            //Creo una v  ariable con el array y paso los parametros
            $item  =array(
                'codigo'=>$codigo,
             
            

            );
            http_response_code(200);
            array_push($array_pedido['data'],$item);


           

         }
         echo json_encode($array_pedido);

    }else
    {
        http_response_code(404);
        echo json_encode(array("message" =>"No  found"));
    }


?>