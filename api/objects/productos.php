<?php

    class Producto
    {
        private $conn;
        private $tabla = 'Productos';

        //atributos
        public $codigo;
        public $nombre;
        public $descripcion;
        public $precio;
        public $sw_stock;
        public $tipo_producto;
        public $id_unidad_medida;
        

        public function __construct($db)
        {
            $this->conn = $db;
        }

        public function mostrar()
        {
            $query = 'SELECT
                p.codigo,p.nombre,p.descripcion,p.precio,p.sw_stock,p.tipo_producto,u.nombre as unidad
              FROM '.$this->tabla.' p,Unidad_Medida u WHERE p.id_unidad_medida=u.codigo ';
            //preparo la consulta
            $estamento = $this->conn->prepare($query);
            //ejecuto la consulta
            $estamento->execute();
            //retorno la consulta
            return  $estamento;
        }
        public function mostrarBebidas()
        {
            $query = 'SELECT
                p.codigo,p.nombre,p.descripcion,p.precio,p.sw_stock,p.tipo_producto,u.nombre as unidad
              FROM '.$this->tabla.' p,Unidad_Medida u WHERE p.id_unidad_medida=u.codigo AND p.tipo_producto="B" ';
            //preparo la consulta
            $estamento = $this->conn->prepare($query);
            //ejecuto la consulta
            $estamento->execute();
            //retorno la consulta
            return  $estamento;
        }

        public function DropDownUnidad()
        {
            $query='SELECT codigo,nombre  FROM Unidad_Medida WHERE tipo="B"';
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
            descripcion=:descripcion,
            id_mesa=:id_mesa,
            id_mesero=:id_mesero
            
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros
        $this->descripcion  = htmlspecialchars(strip_tags(strtoupper($this->descripcion)));
        $this->id_mesa  = htmlspecialchars(strip_tags($this->id_mesa));
        $this->id_mesero  = htmlspecialchars(strip_tags($this->id_mesero));

        //enlazo los values
        $estamento->bindParam(':descripcion',$this->descripcion);
        $estamento->bindParam(':id_mesa',$this->id_mesa);
        $estamento->bindParam(':id_mesero',$this->id_mesero);

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