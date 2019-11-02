<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');

    include_once '../objects/mesas.php';
    include_once '../config/basedatos.php';

    $database =  new  Database();
    $db = $database->connect();

    $mesa = new Mesas($db);
    $resultado  =$mesa->mostrar();
    $numero  = $resultado->rowCount();
    


    if($numero>0)
    {
        $array_mesa=array();
        $array_mesa['data']=array();
        while($fila = $resultado->fetch(PDO::FETCH_ASSOC))
        {
            extract($fila);
            //Creo una v  ariable con el array y paso los parametros
            $item  =array(
                'codigo'=>$codigo,
                'nombre'=>$nombre,
                'estado'=>$estado,
                'capacidad'=>$capacidad
            

            );
            http_response_code(200);
            array_push($array_mesa['data'],$item);


           

         }
         echo json_encode($array_mesa);

    }else
    {
        http_response_code(404);
        echo json_encode(array("message" =>"No  found"));
    }


?>