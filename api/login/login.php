<?php 
 header("Access-Control-Allow-Origin: http://localhost:8080/Api_Restaurante/api/login/login.php");
 header("Content-Type: application/json; charset=UTF-8");
 header("Access-Control-Allow-Methods: POST");
 header("Access-Control-Max-Age: 3600");
 header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");
 //------------------------web token
 // generate json web token
include_once '../config/core.php';
include_once '../libs/php-jwt-master/php-jwt-master/src/BeforeValidException.php';
include_once '../libs/php-jwt-master/php-jwt-master/src/ExpiredException.php';
include_once '../libs/php-jwt-master/php-jwt-master/src/SignatureInvalidException.php';
include_once '../libs/php-jwt-master/php-jwt-master/src/JWT.php';
use \Firebase\JWT\JWT;
//------------------------mis archivos

 include_once '../config/basedatos.php';
 include_once '../objects/usuario.php';

 $database = new Database();
 $db = $database->connect();
 $usuarios = new Usuarios($db);

 $data = json_decode(file_get_contents("php://input"));
 
 $usuarios->email =$data->email;
 $email_exists = $usuarios->validar();

 if($email_exists && password_verify($data->password,$usuarios->password)){
 
    $token = array(
       "iss" => $iss,
       "aud" => $aud,
       "iat" => $iat,
       "nbf" => $nbf,
       "data" => array(
           "id" => $usuarios->id_persona,
           "usuario" => $usuarios->usuario,
           "password" => $usuarios->password
       )
    );
 
    // set response code
    http_response_code(200);
 
    // generate jwt
    $jwt = JWT::encode($token, $key);
    echo json_encode(
            array(
                "message" => "Successful login.",
                "jwt" => $jwt
            )
        );
 
}// login failed
else{
 
    // set response code
    http_response_code(401);
 
    // tell the user login failed
    echo json_encode(array("message" => "Login failed."));
}



?>