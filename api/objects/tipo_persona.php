<?php

    class Tipo_Persona
    {
        private $conn;
        private $tabla = 'tipo_persona';

        //atributos
        public $id;
        public $descripcion;
       
        

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
        public function crear()
        {
            $query = 'INSERT INTO '.$this->tabla.' SET 
            descripcion=:descripcion 
            
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros
        $this->descripcion = htmlspecialchars(strip_tags(strtoupper($this->descripcion)));
        

        //enlazo los values
        $estamento->bindParam(':descripcion',$this->descripcion);
        

        if($estamento->execute())
        {
          
            return true;
        }
       
        return false;
        }


        //funcion editar
        
        public function editar()
        {
            $query = 'UPDATE '.$this->tabla.' SET 
            descripcion=:descripcion
            WHERE id=:id
            
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros
        $this->descripcion = htmlspecialchars(strip_tags(strtoupper($this->descripcion)));
        $this->id  = htmlspecialchars(strip_tags($this->id));
       
        //enlazo los values
        $estamento->bindParam(':descripcion',$this->descripcion);
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