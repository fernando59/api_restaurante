<?php

    class Personas
    {
        private $conn;
        private $tabla = 'Persona';

        //atributos
        public $id;
        public $nombre;
        public $apellido;
        public $edad;
        public $telefono;
        public $direccion;
        public $carnet;
     
        

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function mostrar()
        {
            $query = 'SELECT 
                p.id,p.nombre,p.apellido,p.edad,p.telefono,
                p.direccion,p.ci,t.descripcion as descripcion
              FROM '.$this->tabla.' p,tipo_persona t WHERE p.tipo_per=t.id ';
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
            carnet=:carnet
           
            
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros
        $this->nombre  = htmlspecialchars(strip_tags(strtoupper($this->nombre)));
        $this->apellido  = htmlspecialchars(strip_tags($this->apellido));
        $this->edad  = htmlspecialchars(strip_tags($this->edad));
        $this->telefono  = htmlspecialchars(strip_tags(strtoupper($this->telefono)));
        $this->direccion  = htmlspecialchars(strip_tags($this->direccion));
        $this->carnet  = htmlspecialchars(strip_tags($this->carnet));
      

        //enlazo los values
        $estamento->bindParam(':nombre',$this->nombre);
        $estamento->bindParam(':apellido',$this->apellido);
        $estamento->bindParam(':edad',$this->edad);
        $estamento->bindParam(':telefono',$this->telefono);
        $estamento->bindParam(':direccion',$this->direccion);
        $estamento->bindParam(':carnet',$this->carnet);
       

        if($estamento->execute())
        {
       
            return true;
        }
      
        return false;
        }
        public function mostrarMeseros()
        {
            $query = 'SELECT 
             p.codigo,p.nombre as nombre
              FROM '.$this->tabla.' p,Mesero m WHERE p.codigo=m.codigo';
            //preparo la consulta
            $estamento = $this->conn->prepare($query);
            //ejecuto la consulta
            $estamento->execute();
            //retorno la consulta
            return  $estamento;
        }
        public function mostrarClientes()
        {
            $query = 'SELECT 
             p.codigo,p.nombre,p.apellido,p.telefono,p.direccion,p.carnet,m.nit
              FROM '.$this->tabla.' p,Cliente m WHERE p.codigo=m.codigo';
            //preparo la consulta
            $estamento = $this->conn->prepare($query);
            //ejecuto la consulta
            $estamento->execute();
            //retorno la consulta
            return  $estamento;
        }
        /*
        
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
        */
        public function eliminar($idd)
        {
            $query = 'DELETE FROM '.$this->tabla.' WHERE id= ?';
            $estamento = $this->conn->prepare($query);

           // $this->idd=htmlspecialchars(strip_tags($this->idd));
 
           
            $estamento->bindParam(1, $idd);
           
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