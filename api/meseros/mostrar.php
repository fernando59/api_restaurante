<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');

    include_once '../objects/mesero.php';
    include_once '../config/basedatos.php';

    $database =  new  Database();
    $db = $database->connect();

    $mesero = new Mesero($db);
    $resultado  =$mesero->mostrar();
    $numero  = $resultado->rowCount();
    
  

    if($numero>0)
    {
        $array_mesero=array();
        $array_mesero['data']=array();
        while($fila = $resultado->fetch(PDO::FETCH_ASSOC))
        {
            extract($fila);
            //Creo una v  ariable con el array y paso los parametros
            $item  =array(
                'id'=>$id,
                'nombre'=>$nombre,
                'apellido'=>$apellido,
                'edad'=>$edad,
                'telefono '=>$telefono,
                'direccion'=>$direccion,
                'carnet'=>$ci

            );
            http_response_code(200);
            array_push($array_mesero['data'],$item);


           

         }
         echo json_encode($array_mesero);

    }else
    {
        http_response_code(404);
        echo json_encode(array("message" =>"No products found"));
    }


?>