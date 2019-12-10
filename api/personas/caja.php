<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');

    include_once '../objects/persona.php';
    include_once '../config/basedatos.php';

    $database =  new  Database();
    $db = $database->connect();

    $persona= new Personas($db);
    $resultado  =$persona->mostrarCaja();
    $numero  = $resultado->rowCount();
    
  

    if($numero>0)
    {
        $array_persona=array();
        $array_persona['data']=array();
        while($fila = $resultado->fetch(PDO::FETCH_ASSOC))
        {
            extract($fila);
            //Creo una v  ariable con el array y paso los parametros
            $item  =array(
                'codigo'=>$codigo,
                'nombre'=>$nombre,
                'apellido'=>$apellido,
                'telefono'=>$telefono,
                'direccion'=>$direccion,
                'edad'=>$edad,
                'carnet'=>$carnet,
                'descripcion'=>$descripcion
              

            );
            http_response_code(200);
            array_push($array_persona['data'],$item);


           

         }
         echo json_encode($array_persona);

    }else
    {
        http_response_code(404);
        echo json_encode(array("message" =>"No persons found"));
    }


?>