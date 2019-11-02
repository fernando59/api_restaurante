<?php 
    header('Access-Control-Allow-Origin:*');
    header('Content-Type:application/json');

    include_once '../objects/usuario.php';
    include_once '../config/basedatos.php';

    $database =  new  Database();
    $db = $database->connect();

    $usuario = new Usuarios($db);
    $resultado  =$usuario->validar();
    $numero  = $resultado->rowCount();
    


    if($numero>0)
    {
        $array_usuario=array();
        $array_usuario['data']=array();
        while($fila = $resultado->fetch(PDO::FETCH_ASSOC))
        {
            extract($fila);
            //Creo una v  ariable con el array y paso los parametros
            $item  =array(
                'email'=>$email
            );
            http_response_code(200);
            array_push($array_usuario['data'],$item);


           

         }
         echo json_encode($array_usuario);

    }else
    {
        http_response_code(404);
        echo json_encode(array("message" =>"No  found"));
    }


?>