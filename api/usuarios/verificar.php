<?php 
    header('Access-Control-Allow-Origin: *');
    header('Content-Type:application/json');
    header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");  
    header("Access-Control-Allow-Methods: POST");
    include_once '../objects/usuario.php';
    include_once '../config/basedatos.php';

    $database =  new  Database();
    $db = $database->connect();
    $data = json_decode(file_get_contents("php://input"));
    $usuario = new Usuarios($db);
    $usuario->nombre_usuario=$data->nombre_usuario;
    $usuario->password_usuario=$data->password_usuario;
   
    $resultado  =$usuario->seleccionarUsuario();
    $numero  = $resultado->rowCount();
    


    if($numero>0)
    {
        $array_usuario=array();
        $array_usuario['data']=array();
        http_response_code(200);
        echo json_encode(array('messsage'=>'Login exitoso'));

    }else
    {
        http_response_code(200);
        echo json_encode(array("message" =>"No  found"));
    }


?>