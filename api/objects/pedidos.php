<?php

    class Pedidos
    {
        private $conn;
        private $tabla = 'pedido';

        //atributos
        public $id;
        public $estado;
        public $id_reserva;
        public $id_mesero;
        public $fecha;
        

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function mostrar()
        {
            $query = 'SELECT p.id,p.descripcion,m.nombre as id_mesa,me.nombre as id_mesero FROM '.$this->tabla.' p,mesa m,mesero me WHERE id_mesa=m.id AND id_mesero=me.id ';
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
            estado=:estado,
            id_reserva=:id_reserva,
            id_mesero=:id_mesero
            
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros
        $this->estado  = htmlspecialchars(strip_tags(strtoupper($this->estado)));
        $this->id_reserva  = htmlspecialchars(strip_tags($this->id_reserva));
        $this->id_mesero  = htmlspecialchars(strip_tags($this->id_mesero));
        $this->fecha = htmlspecialchars(strip_tags($this->fecha));
        //enlazo los values
        $estamento->bindParam(':fecha',$this->fecha);
        $estamento->bindParam(':id_reserva',$this->id_reserva);
        $estamento->bindParam(':id_mesero',$this->id_mesero);
        $estamento->bindParam(':estado',$this->estado);
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