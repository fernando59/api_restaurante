<?php

    class Usuarios
    {
        private $conn;
        private $tabla = 'usuario';

        //atributos
        public $codigo;
        public $nombre_usuario;
        public $password_usuario;
        public $email;
        public $codigo_usuario;
        public $estado;
        

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function mostrar()
        {
            $query = 'SELECT
            Persona.codigo,
            Persona.nombre,
            Persona.apellido,
            Persona.telefono,
            Persona.edad,
            Persona.carnet,
            Persona.direccion,
            Usuario.nombre_usuario,
            Usuario.email
        FROM
            persona 
        LEFT JOIN '.$this->tabla.' ON usuario.codigo = persona.codigo';
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
            codigo=:codigo,
            nombre_usuario=:nombre_usuario,
            password_usuario=:password_usuario,
            email=:email,
            codigo_usuario=:codigo_usuario,
            estado=:estado
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros
        $this->codigo  = htmlspecialchars(strip_tags($this->codigo));
        $this->nombre_usuario  = htmlspecialchars(strip_tags(strtoupper($this->nombre_usuario)));
        $this->password_usuario  = htmlspecialchars(strip_tags($this->password_usuario));
        $this->email  = htmlspecialchars(strip_tags($this->email));
        $this->codigo_usuario  = htmlspecialchars(strip_tags($this->codigo_usuario));
        $this->estado  = htmlspecialchars(strip_tags($this->estado));
       
        //enlazo los values
        $estamento->bindParam(':codigo',$this->codigo);
        $estamento->bindParam(':nombre_usuario',$this->nombre_usuario);
        $estamento->bindParam(':estado',$this->estado);
        $estamento->bindParam(':email',$this->email);
        $estamento->bindParam(':codigo_usuario',$this->codigo_usuario);
        //Encripto la contraseña
        //$password_hash = password_hash($this->password,PASSWORD_BCRYPT);
        $estamento->bindParam(':password_usuario',$this->password_usuario);
      
        if($estamento->execute())
        {
          
            return true;
        }
       
        return false;
        }
        public function seleccionarUsuario()
        {
            $query = "SELECT * FROM usuario 
            WHERE usuario.nombre_usuario=:nombre_usuario 
            and usuario.password_usuario=:password_usuario
             ";
             $estamento = $this->conn->prepare($query);
            //preparo la consulta
            $estamento->bindParam(':nombre_usuario',$this->nombre_usuario);
            $estamento->bindParam(':password_usuario',$this->password_usuario);
            
            //ejecuto la consulta
          
             $estamento->execute();
          return $estamento;
            //retorno la consulta
           
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
            $query = 'SELECT
            Persona.codigo,
            Persona.nombre,
            Persona.apellido,
            Persona.telefono,
            Persona.edad,
            Persona.carnet,
            Persona.direccion,
            Usuario.nombre_usuario,
            Usuario.email
        FROM
            Persona 
        LEFT JOIN '.$this->tabla.' ON Usuario.codigo = Persona.codigo WHERE Usuario.email LIKE ? OR Usuario.nombre_usuario LIKE ? AND estado="A" LIMIT 0,10';
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