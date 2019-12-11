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
        public $mesa;

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
        public function obetnerUltimoId()
        {
            $query = 'SELECT codigo
            FROM '.$this->tabla.'  order by codigo desc limit 1';
            //preparo la consulta
            $estamento = $this->conn->prepare($query);
            //ejecuto la consulta
            $estamento->execute();
            //retorno la consulta
            return  $estamento;
        }
        public function mostrarTodo()
        {
            $query = '
            SELECT reserva.codigo as codigo_reserva, pedido.codigo as codigo_pedido, 
            reserva.hora, cliente.nit, mesa.nombre as mesa,persona.nombre,mesa.codigo as codigoMesa
            FROM reserva, pedido, mesa, 
            cliente,persona, detalle_reseva WHERE reserva.codigo = pedido.id_reserva AND 
            reserva.codigo = detalle_reseva.id_reserva AND mesa.codigo = detalle_reseva.id_mesa AND reserva.id_cliente = cliente.codigo AND mesa.estado = "B" AND 
            reserva.estado = "SOLICITADO" AND reserva.tipo_reserva = "A" AND persona.codigo=cliente.codigo
            ';
            //preparo la consulta
            $estamento = $this->conn->prepare($query);
            //ejecuto la consulta
            $estamento->execute();
            //retorno la consulta
            return  $estamento;
        }
        public function mostrarTodo2($mesa)
        {
            $query = '
            SELECT reserva.codigo as codigo_reserva, pedido.codigo as codigo_pedido, 
            reserva.hora, cliente.nit, mesa.nombre as mesa,persona.nombre,persona.carnet,persona.apellido,pedido.fecha,persona.codigo as id_persona
             FROM reserva, pedido, mesa, 
            cliente,persona, detalle_reseva WHERE reserva.codigo = pedido.id_reserva AND 
            reserva.codigo = detalle_reseva.id_reserva AND mesa.codigo = detalle_reseva.id_mesa AND reserva.id_cliente = cliente.codigo AND mesa.estado = "B" AND 
            reserva.estado = "SOLICITADO" AND reserva.tipo_reserva = "A" AND persona.codigo=cliente.codigo AND mesa.codigo=?
            ';
            //preparo la consulta
            $estamento = $this->conn->prepare($query);
            $estamento->bindParam(1,$mesa);
            //ejecuto la consulta
            $estamento->execute();
            //retorno la consulta
            return  $estamento;
        }
        public function mostrarProductos($pedido)
        {
           
                $query = '
                SELECT productos.codigo,productos.nombre,productos.precio,COUNT(productos.codigo) AS cantidad,pedido.codigo as pedido
                from pedido,reserva,detalle_pedido,productos 
                WHERE pedido.id_reserva=reserva.codigo and pedido.codigo=detalle_pedido.id_pedido 
                and productos.codigo=detalle_pedido.id_producto and pedido.codigo=?
                GROUP BY(productos.codigo)
                ';
                //preparo la consulta
                $estamento = $this->conn->prepare($query);
                $estamento->bindParam(1,$pedido);
                //ejecuto la consulta
                $estamento->execute();
                //retorno la consulta
                return  $estamento;
            
            //preparo la consulta
            $estamento = $this->conn->prepare($query);
            $estamento->bindParam(1,$mesa);
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