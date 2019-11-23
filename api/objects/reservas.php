<?php

    class Reserva
    {
        private $conn;
        private $tabla = 'Reserva';

        //atributos
        public $codigo;
        public $fecha;
        public $tipo_reserva;
        public $id_cliente;
        public $hora;
        public $observaciones;
        public $numero_personas;
        public $estado;
        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function mostrar()
        {
            $query = 'SELECT r.codigo,r.fecha,r.tipo_reserva,r.id_cliente,cl.nombre as nombre 
            FROM '.$this->tabla.' r,Cliente c,Persona cl WHERE r.id_cliente=c.codigo AND cl.codigo=c.codigo ';
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
            fecha=:fecha,
            tipo_reserva=:tipo_reserva,
            id_cliente=:id_cliente,
            estado=:estado,
            observaciones=:observaciones,
            hora=:hora,
            numero_personas=:numero_personas
            
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros
        $this->fecha = htmlspecialchars(strip_tags($this->fecha));
        $this->tipo_reserva  = htmlspecialchars(strip_tags($this->tipo_reserva));
        $this->id_cliente  = htmlspecialchars(strip_tags($this->id_cliente));
        $this->numero_personas = htmlspecialchars(strip_tags($this->numero_personas));
        $this->hora  = htmlspecialchars(strip_tags($this->hora));
        $this->observaciones  = htmlspecialchars(strip_tags($this->observaciones));
        $this->estado = htmlspecialchars(strip_tags($this->estado));
        //enlazo los values
        $estamento->bindParam(':fecha',$this->fecha);
        $estamento->bindParam(':tipo_reserva',$this->tipo_reserva);
        $estamento->bindParam(':id_cliente',$this->id_cliente);
        $estamento->bindParam(':estado',$this->estado);
        $estamento->bindParam(':numero_personas',$this->numero_personas);
        $estamento->bindParam(':hora',$this->hora);
        $estamento->bindParam(':observaciones',$this->observaciones);
        if($estamento->execute())
        {
       
            return true;
        }
      
        return false;
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


*/
    }




?>