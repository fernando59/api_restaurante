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
                p.codigo,p.nombre,p.descripcion,p.precio,p.sw_stock,p.tipo_producto,u.nombre as unidad,u.codigo as id_unidad_medida
              FROM '.$this->tabla.' p,Unidad_Medida u WHERE p.id_unidad_medida=u.codigo AND p.tipo_producto="B" ';
            //preparo la consulta
            $estamento = $this->conn->prepare($query);
            //ejecuto la consulta
            $estamento->execute();
            //retorno la consulta
            return  $estamento;
        }
        public function mostrarPlatos()
        {
            $query = 'SELECT
                p.codigo,p.nombre,p.descripcion,p.precio,p.sw_stock,p.tipo_producto,u.nombre as unidad,u.codigo as id_unidad_medida
              FROM '.$this->tabla.' p,Unidad_Medida u WHERE p.id_unidad_medida=u.codigo AND p.tipo_producto!="B" ';
            //preparo la consulta
            $estamento = $this->conn->prepare($query);
            //ejecuto la consulta
            $estamento->execute();
            //retorno la consulta
            return  $estamento;
        }
        public function DropDownUnidad()
        {
            $query='SELECT * FROM Unidad_Medida WHERE tipo="B"';
             //preparo la consulta
             $estamento = $this->conn->prepare($query);
             //ejecuto la consulta
             $estamento->execute();
             //retorno la consulta
             return  $estamento;
        }

        public function DropDownUnidad2()
        {
            $query='SELECT * FROM Unidad_Medida WHERE tipo="A"';
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
            descripcion=:descripcion,
            precio=:precio,
            sw_stock=:sw_stock,
            tipo_producto=:tipo_producto,
            id_unidad_medida=:id_unidad_medida
          
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros
        $this->nombre  = htmlspecialchars(strip_tags(strtoupper($this->nombre)));
        $this->descripcion  = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio  = htmlspecialchars(strip_tags($this->precio));
        $this->sw_stock  = htmlspecialchars(strip_tags($this->sw_stock));
        $this->tipo_producto  = htmlspecialchars(strip_tags($this->tipo_producto));
        $this->id_unidad_medida  = htmlspecialchars(strip_tags($this->id_unidad_medida));
        //enlazo los values
        $estamento->bindParam(':nombre',$this->nombre);
        $estamento->bindParam(':descripcion',$this->descripcion);
        $estamento->bindParam(':precio',$this->precio);
        $estamento->bindParam(':sw_stock',$this->sw_stock);
        $estamento->bindParam(':tipo_producto',$this->tipo_producto);
        $estamento->bindParam(':id_unidad_medida',$this->id_unidad_medida);

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
            descripcion=:descripcion,
            precio=:precio,
            sw_stock=:sw_stock,
            tipo_producto=:tipo_producto,
            id_unidad_medida=:id_unidad_medida WHERE codigo=:codigo
          
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros
        $this->codigo= htmlspecialchars(strip_tags($this->codigo));
        $this->nombre  = htmlspecialchars(strip_tags(strtoupper($this->nombre)));
        $this->descripcion  = htmlspecialchars(strip_tags($this->descripcion));
        $this->precio  = htmlspecialchars(strip_tags($this->precio));
        $this->sw_stock  = htmlspecialchars(strip_tags($this->sw_stock));
        $this->tipo_producto  = htmlspecialchars(strip_tags($this->tipo_producto));
        $this->id_unidad_medida  = htmlspecialchars(strip_tags($this->id_unidad_medida));
        //enlazo los values
        $estamento->bindParam(':codigo',$this->codigo);
        $estamento->bindParam(':nombre',$this->nombre);
        $estamento->bindParam(':descripcion',$this->descripcion);
        $estamento->bindParam(':precio',$this->precio);
        $estamento->bindParam(':sw_stock',$this->sw_stock);
        $estamento->bindParam(':tipo_producto',$this->tipo_producto);
        $estamento->bindParam(':id_unidad_medida',$this->id_unidad_medida);

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
        */
        public function eliminar($id)
        {
            $query = 'DELETE FROM '.$this->tabla.' WHERE codigo= ?';
            $estamento = $this->conn->prepare($query);
            $estamento->bindParam(1, $id);
        
            // execute query
            if($estamento->execute()){
                return true;
            }
        
            return false;
        }
        /*
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