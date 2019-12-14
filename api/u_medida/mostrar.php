<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');

    include_once '../objects/u_medida.php';
    include_once '../config/basedatos.php';

    $database =  new  Database();
    $db = $database->connect();

    $u_medida= new U_Medida($db);
    $resultado  =$u_medida->mostrar();
    $numero  = $resultado->rowCount();
    
  

    if($numero>0)
    {
        $array_u_medida=array();
        $array_u_medida['data']=array();
        while($fila = $resultado->fetch(PDO::FETCH_ASSOC))
        {
            extract($fila);
            //Creo una v  ariable con el array y paso los parametros
            $item  =array(
                'codigo'=>$codigo,
                'nombre'=>$nombre,
                'tipo'=>$tipo
              

            );
            http_response_code(200);
            array_push($array_u_medida['data'],$item);


           

         }
         echo json_encode($array_u_medida);

    }else
    {
        http_response_code(404);
        echo json_encode(array("message" =>"No persons found"));
    }


?>