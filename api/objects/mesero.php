<?php 

    class Mesero
    {
        private $tabla ='mesero';
        private $conn;
        //atributos
        public $id;
        public $nombre;
        public $apellido;
        public $edad;
        public $telefono;
        public $direccion;
        public $ci;

        //constructor

        public function __construct($db)
        {
            $this->conn = $db;
        }
        //funciones

        public function mostrar()
        {
            $query = 'SELECT * FROM '.$this->tabla;
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
                nombre=:nombre,
                apellido=:apellido,
                edad=:edad,
                telefono=:telefono,
                direccion=:direccion,
                ci=:ci
            ';
            $estamento = $this->conn->prepare($query);

            //paso los parametros
            $this->nombre  = htmlspecialchars(strip_tags(strtoupper($this->nombre)));
            $this->apellido  = htmlspecialchars(strip_tags(strtoupper($this->apellido)));
            $this->edad  = htmlspecialchars(strip_tags($this->edad));
            $this->telefono  = htmlspecialchars(strip_tags($this->telefono));
            $this->direccion  = htmlspecialchars(strip_tags(strtoupper($this->direccion)));
            $this->ci  = htmlspecialchars(strip_tags(strtoupper($this->ci)));

            //enlazo los values
            $estamento->bindParam(':nombre',$this->nombre);
            $estamento->bindParam(':apellido',$this->apellido);
            $estamento->bindParam(':edad',$this->edad);
            $estamento->bindParam(':telefono',$this->telefono);
            $estamento->bindParam(':direccion',$this->direccion);
            $estamento->bindParam(':ci',$this->ci);

            if($estamento->execute())
            {
                return true;
            }
            return false;
        }

        public function editar()
        {
            $query = 'UPDATE '.$this->tabla.' SET 
            nombre=:nombre,
            apellido=:apellido,
            edad=:edad,
            telefono=:telefono,
            direccion=:direccion,
            ci=:ci WHERE id=:id
            ';
            $estamento = $this->conn->prepare($query);
            //paso los parametros
            $this->nombre  = htmlspecialchars(strip_tags(strtoupper($this->nombre)));
            $this->apellido  = htmlspecialchars(strip_tags(strtoupper($this->apellido)));
            $this->edad  = htmlspecialchars(strip_tags($this->edad));
            $this->telefono  = htmlspecialchars(strip_tags($this->telefono));
            $this->direccion  = htmlspecialchars(strip_tags(strtoupper($this->direccion)));
            $this->ci  = htmlspecialchars(strip_tags(strtoupper($this->ci)));

            //enlazo los values
            $estamento->bindParam(':nombre',$this->nombre);
            $estamento->bindParam(':apellido',$this->apellido);
            $estamento->bindParam(':edad',$this->edad);
            $estamento->bindParam(':telefono',$this->telefono);
            $estamento->bindParam(':direccion',$this->direccion);
            $estamento->bindParam(':ci',$this->ci);
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
            $query = 'SELECT * FROM '.$this->tabla.' WHERE nombre LIKE ? OR edad LIKE ?  LIMIT 0,10';
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