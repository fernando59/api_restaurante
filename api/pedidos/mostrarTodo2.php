<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');
    header("Access-Control-Allow-Methods:GET");
    include_once '../objects/pedidos.php';
    include_once '../config/basedatos.php';

    $database =  new  Database();
    $db = $database->connect();

    $pedido = new Pedidos($db);
    $palabra = isset($_GET['s'])?$_GET['s']:'';
    $resultado  =$pedido->mostrarTodo2($palabra);
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
                'codigo_reserva'=>$codigo_reserva,
                'codigo_pedido'=>$codigo_pedido,
                'hora'=>$hora,
                'nit'=>$nit,
                'mesa'=>$mesa,
                'nombre'=>$nombre,
                'carnet'=>$carnet,
                'apellido'=>$apellido,
                'fecha'=>$fecha,
                'id_persona'=>$id_persona,
                'codigo_mesa'=>$codigo_mesa
            

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