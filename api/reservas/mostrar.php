<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');

    include_once '../objects/reservas.php';
    include_once '../config/basedatos.php';

    $database =  new  Database();
    $db = $database->connect();

    $reserva = new Reserva($db);
    $resultado  =$reserva->mostrar();
    $numero  = $resultado->rowCount();
    

    echo $numero;
    if($numero>0)
    {
        $array_reserva=array();
        $array_reserva['data']=array();
        while($fila = $resultado->fetch(PDO::FETCH_ASSOC))
        {
            extract($fila);
            //Creo una v  ariable con el array y paso los parametros
            $item  =array(
                'codigo'=>$codigo,
                'fecha'=>$fecha,
                'tipo_reserva'=>$tipo_reserva,
                'id_cliente'=>$id_cliente,
                'nombre'=>$nombre
           
              
            

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