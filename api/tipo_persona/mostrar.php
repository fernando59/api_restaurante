<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');

    include_once '../objects/tipo_persona.php';
    include_once '../config/basedatos.php';

    $database =  new  Database();
    $db = $database->connect();

    $tipo_persona = new Tipo_Persona($db);
    $resultado  =$tipo_persona->mostrar();
    $numero  = $resultado->rowCount();
    


    if($numero>0)
    {
        $array_tipo_persona=array();
        $array_tipo_persona['data']=array();
        while($fila = $resultado->fetch(PDO::FETCH_ASSOC))
        {
            extract($fila);
            //Creo una v  ariable con el array y paso los parametros
            $item  =array(
                'id'=>$id,
                'descripcion'=>$descripcion,
              
            

            );
            http_response_code(200);
            array_push($array_tipo_persona['data'],$item);


           

         }
         echo json_encode($array_tipo_persona);

    }else
    {
        http_response_code(404);
        echo json_encode(array("message" =>"No  found"));
    }


?>