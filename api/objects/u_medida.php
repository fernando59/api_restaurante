<?php 

    class U_medida
    {
        private $tabla ='Unidad_Medida';
        private $conn;
        //atributos
        public $codigo;
        public $nombre;
      

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
                nombre=:nombre
            ';
            $estamento = $this->conn->prepare($query);
            //paso los parametros
            $this->nombre  = htmlspecialchars(strip_tags(strtoupper($this->nombre)));
            //enlazo los values
            $estamento->bindParam(':nombre',$this->nombre);
         
            if($estamento->execute())
            {
                return true;
            }
            return false;
        }

        public function editar()
        {
            $query = 'UPDATE '.$this->tabla.' SET 
            nombre=:nombre
             WHERE codigo=:codigo
            ';
            $estamento = $this->conn->prepare($query);
            //paso los parametros
            $this->nombre  = htmlspecialchars(strip_tags(strtoupper($this->nombre)));

            //enlazo los values
            $estamento->bindParam(':nombre',$this->nombre);
            $estamento->bindParam(':codigo',$this->codigo);
            if($estamento->execute())
            {
                return true;
            }
            return false;

        }

        public function eliminar($codigo)
        {
            $query = 'DELETE FROM '.$this->tabla.' WHERE codigo= ?';
            $estamento = $this->conn->prepare($query);
            $estamento->bindParam(1, $codigo);
        
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