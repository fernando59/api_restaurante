<?php

    class Mesas
    {
        private $conn;
        private $tabla = 'mesa';

        //atributos
        public $codigo;
        public $nombre;
        public $estado;
        public $capacidad;
        

        public function __construct($db)
        {
            $this->conn = $db;
        }

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
        public function mostrarUno($id)
        {
            $query = 'SELECT * FROM '.$this->tabla.' WHERE codigo=?';
            //preparo la consulta
            $estamento = $this->conn->prepare($query);
            $estamento->bindParam(1, $id);
        
            // execute query
            if($estamento->execute()){
                return true;
            }
        
            return false;
        }
        public function crear()
        {
            $query = 'INSERT INTO '.$this->tabla.' SET 
            nombre=:nombre,
            estado=:estado,
            capacidad=:capacidad
            
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros
        $this->nombre  = htmlspecialchars(strip_tags(strtoupper($this->nombre)));
        $this->estado  = htmlspecialchars(strip_tags($this->estado));
        $this->capacidad  = htmlspecialchars(strip_tags($this->capacidad));

        //enlazo los values
        $estamento->bindParam(':nombre',$this->nombre);
        $estamento->bindParam(':estado',$this->estado);
        $estamento->bindParam(':capacidad',$this->capacidad);

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
            estado=:estado,
            capacidad=:capacidad
            WHERE codigo=:codigo
            
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros
        $this->nombre  = htmlspecialchars(strip_tags(strtoupper($this->nombre)));
        $this->estado  = htmlspecialchars(strip_tags($this->estado));
        $this->capacidad  = htmlspecialchars(strip_tags($this->capacidad));
        $this->codigo  = htmlspecialchars(strip_tags($this->codigo));
        //enlazo los values
        $estamento->bindParam(':nombre',$this->nombre);
        $estamento->bindParam(':estado',$this->estado);
        $estamento->bindParam(':capacidad',$this->capacidad);
        $estamento->bindParam(':codigo',$this->codigo);
        if($estamento->execute())
        {
          
            return true;
        }
       
        return false;
        }
        public function editarr()
        {
            $query = 'UPDATE '.$this->tabla.' SET 
            estado=:estado
            WHERE codigo=:codigo
            
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros

        //enlazo los values
        $estamento->bindParam(':codigo',$this->codigo);
        $estamento->bindParam(':estado',$this->estado);
        if($estamento->execute())
        {
          
            return true;
        }
       
        return false;
        }
        public function eliminar($id)
        {
            $query = 'DELETE FROM '.$this->tabla.' WHERE id= ?';
            $estamento = $this->conn->prepare($query);
            $estamento->bindParam(1, $id);
        
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