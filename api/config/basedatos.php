<?php 

class Database{

    private $host ='localhost';
    private $dbName = 'apirestaurante';
    private $username = 'root';
    private $password ='';
    private $conn;


    public function connect()
    {
        $this->conn = null;
        try{
            $this->conn = new PDO('mysql:host='.$this->host.';dbname='.$this->dbName,  
            $this->username,$this->password);
        }catch(PDOException $e)
        {
            echo 'Connection error'.$e->get_message();
        }
        //retorno la conexion
        return $this->conn;
    }
}


?>