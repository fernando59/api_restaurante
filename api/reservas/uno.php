<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');
    header("Access-Control-Allow-Methods: GET");
    include_once '../objects/reservas.php';
    include_once '../config/basedatos.php';

    $database =  new  Database();
    $db = $database->connect();
    $data = json_decode(file_get_contents("php://input"));
    $reserva = new Reserva($db);
    $codigo = isset($_GET['id'])?$_GET['id']:'';
    $resultado  =$reserva->obtenerUno($codigo);
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
                'codigo'=>$codigo,
                'fecha'=>$fecha,
                'hora'=>$hora,
                'nombre'=>$nombre,
                'estado'=>$estado,
                'observaciones'=>$observaciones,
                'mesas'=>$mesas,
                'apellido'=>$apellido,
                'telefono'=>$telefono
              
            

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