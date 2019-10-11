<?php

    class Usuarios
    {
        private $conn;
        private $tabla = 'usuarios';

        //atributos
        public $id_persona;
        public $usuario;
        public $password;
        public $email;
        public $tipo_usuario;
        public $estado;
        

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function mostrar()
        {
            $query = 'SELECT u.id_persona,u.usuario,u.password,u.email,t.descripcion as tipo_usuario
                FROM '.$this->tabla.' u,tipo_usuario t WHERE u.tipo_usuario=t.id';
            //preparo la consulta
            $estamento = $this->conn->prepare($query);
            //ejecuto la consulta
            $estamento->execute();
            //retorno la consulta
            return  $estamento;
        }
        public function crear()
        {
            $query = 'INSERT INTO '.$this->tabla.' SET 
            id_persona=:id_persona,
            usuario=:usuario,
            password=:password,
            email=:email,
            tipo_usuario=:tipo_usuario,
            estado=:estado  
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros
        $this->id_persona  = htmlspecialchars(strip_tags($this->id_persona));
        $this->usuario  = htmlspecialchars(strip_tags(strtoupper($this->usuario)));
        $this->password  = htmlspecialchars(strip_tags($this->password));
        $this->email  = htmlspecialchars(strip_tags($this->email));
        $this->tipo_usuario  = htmlspecialchars(strip_tags($this->tipo_usuario));
        $this->estado  = htmlspecialchars(strip_tags($this->estado));
      
       
        //enlazo los values
        $estamento->bindParam(':id_persona',$this->id_persona);
        $estamento->bindParam(':usuario',$this->usuario);
        $estamento->bindParam(':estado',$this->estado);
        $estamento->bindParam(':email',$this->email);
        $estamento->bindParam(':tipo_usuario',$this->tipo_usuario);
        //Encripto la contraseña
        $password_hash = password_hash($this->password,PASSWORD_BCRYPT);
        $estamento->bindParam(':password',$password_hash);
      
        if($estamento->execute())
        {
          
            return true;
        }
       
        return false;
        }
        
        public function validar()
        {
            $query = "SELECT id_persona,usuario,password as con ".$this->tabla." WHERE email= ? LIMIT 0,1";
            $estamento =$this->conn->prepare($query);
            echo $this->email;
           
            $this->email  = htmlspecialchars(strip_tags($this->email));
            $estamento->bindParam(1,$this->email);
            $estamento->execute();
            
            //cuento el numero de filas
            $num= $estamento->rowCount();
            echo $num;
            if($num==0)
            {
                $row = $estamento->fetch(PDO::FETCH_ASSOC);

                $this->id = $row['id'];
                $this->usuario = $row['usuario'];
                $this->password = $row['password'];
                return true;
            }
            return false;
          

        }

        public function editar()
        {
            $query = 'UPDATE '.$this->tabla.' SET 
            nombre=:nombre,
            estado=:estado,
            capacidad=:capacidad
            WHERE id=:id
            
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros
        $this->nombre  = htmlspecialchars(strip_tags(strtoupper($this->nombre)));
        $this->estado  = htmlspecialchars(strip_tags($this->estado));
        $this->capacidad  = htmlspecialchars(strip_tags($this->capacidad));
        $this->id  = htmlspecialchars(strip_tags($this->id));
        //enlazo los values
        $estamento->bindParam(':nombre',$this->nombre);
        $estamento->bindParam(':estado',$this->estado);
        $estamento->bindParam(':capacidad',$this->capacidad);
        $estamento->bindParam(':id',$this->id);
        if($estamento->execute())
        {
          
            return true;
        }
       
        return false;
        }
        public function eliminar()
        {
            $query = 'DELETE FROM '.$this->tabla.' WHERE id= ?';
            $estamento = $this->conn->prepare($query);

            $this->id=htmlspecialchars(strip_tags($this->id));
 
           
            $estamento->bindParam(1, $this->id);
        
            // execute query
            if($estamento->execute()){
                return true;
            }
        
            return false;
        }
        public function buscar($palabra)
        {
            $query = 'SELECT * FROM '.$this->tabla.' WHERE nombre LIKE ? OR capacidad LIKE ? AND estado=1  LIMIT 0,10';
            $estamento = $this->conn->prepare($query);

            $palabra=htmlspecialchars(strip_tags($palabra));
            $palabra="%{$palabra}%";

            $estamento->bindParam(1,$palabra);
            $estamento->bindParam(2,$palabra);

            $estamento->execute();
            return $estamento;
        }


    }





?>