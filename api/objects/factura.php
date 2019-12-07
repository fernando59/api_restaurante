<?php 

class Factura
    {
        private $conn;
        private $tabla = 'factura';

        //atributos
        public $codigo;
        public $nit;
        public $fecha;
        public $serie;
        public $total;
        public $id_cajero;
        public $id_metodo_pago;
        public $id_pedido;

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
            nit=:nit,
            fecha=:fecha,
            serie=:serie,
            total=:total,
            id_cajero=:id_cajero,
            id_metodo_pago=:id_metodo_pago,
            id_pedido=:id_pedido
            
        ';
        $estamento = $this->conn->prepare($query);

        //paso los parametros
        $this->nit  = htmlspecialchars(strip_tags($this->nit));
        $this->fecha  = htmlspecialchars(strip_tags($this->fecha));
        $this->serie  = htmlspecialchars(strip_tags($this->serie));
        $this->total = htmlspecialchars(strip_tags($this->total));
        $this->id_cajero = htmlspecialchars(strip_tags($this->id_cajero));
        $this->id_metodo_pago = htmlspecialchars(strip_tags($this->id_metodo_pago));
        $this->id_pedido = htmlspecialchars(strip_tags($this->id_pedido));
        //enlazo los values
        $estamento->bindParam(':fecha',$this->fecha);
        $estamento->bindParam(':nit',$this->nit);
        $estamento->bindParam(':serie',$this->serie);
        $estamento->bindParam(':total',$this->total);
        $estamento->bindParam(':id_cajero',$this->id_cajero);
        $estamento->bindParam(':id_metodo_pago',$this->id_metodo_pago);
        $estamento->bindParam(':id_pedido',$this->id_pedido);
        if($estamento->execute())
        {
       
            return true;
        }
      
        return false;
        }
 }
?>