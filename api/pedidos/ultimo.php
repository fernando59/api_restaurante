<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');

    include_once '../objects/pedidos.php';
    include_once '../config/basedatos.php';

    $database =  new  Database();
    $db = $database->connect();

    $pedido= new Pedidos($db);
    $resultado  =$pedido->obetnerUltimoId();
    $numero  = $resultado->rowCount();
    

    if($numero>0)
    {
        $array_reserva=array();
        $array_reserva['data']=array();
        while($fila = $resultado->fetch(PDO::FETCH_ASSOC))
        {
            extract($fila);
            //Creo una v  ariable con el array y paso los parametros
            $item  =array(
                'codigo'=>$codigo
            );
            http_response_code(200);
            array_push($array_reserva['data'],$item);


           

         }
         echo json_encode($array_reserva);

    }else
    {
        http_response_code(404);
        echo json_encode(array("message" =>"No  found"));
    }


?>