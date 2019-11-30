<?php 

class Database{

    private $host ='remotemysql.com';//localhost
    private $dbName = 'dOMCrtTsXM';//apirestaurante
    private $username = 'dOMCrtTsXM';//root
    private $password ='MpuEQ6dWIq';
    private $conn;
    /*  private $host ='db4free.net';//localhost
    private $dbName = 'restaurante_api';//apirestaurante
    private $username = 'fernando59';//root
    private $password ='1feernando1';
    private $conn;*/

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