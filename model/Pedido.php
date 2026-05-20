<?php

class Pedido implements JsonSerializable
{
    private $id_pedido;
    private $id_usuario;
    private $local;
    private $recoger;
    private $importe_total;
    private $fecha;

    // Campo adicional para guardar el nombre del usuario en consultas JOIN
    private $nombre_usuario;

    // Líneas de pedido asociadas
    private $lineas = [];

    public function __construct()
    {
    }

    public function jsonSerialize(): mixed
    {
        return [
            'id_pedido' => $this->id_pedido,
            'id_usuario' => $this->id_usuario,
            'nombre_usuario' => $this->nombre_usuario ?: 'Usuario Desconocido',
            'local' => (bool)$this->local,
            'recoger' => (bool)$this->recoger,
            'importe_total' => (float)$this->importe_total,
            'fecha' => $this->fecha,
            'lineas' => $this->lineas
        ];
    }

    // Getters and Setters
    public function getId_pedido() { return $this->id_pedido; }
    public function setId_pedido($id) { $this->id_pedido = $id; return $this; }

    public function getId_usuario() { return $this->id_usuario; }
    public function setId_usuario($id) { $this->id_usuario = $id; return $this; }

    public function getLocal() { return $this->local; }
    public function setLocal($local) { $this->local = $local; return $this; }

    public function getRecoger() { return $this->recoger; }
    public function setRecoger($recoger) { $this->recoger = $recoger; return $this; }

    public function getImporte_total() { return $this->importe_total; }
    public function setImporte_total($total) { $this->importe_total = $total; return $this; }

    public function getFecha() { return $this->fecha; }
    public function setFecha($fecha) { $this->fecha = $fecha; return $this; }

    public function getNombreUsuario() { return $this->nombre_usuario; }
    public function setNombreUsuario($nombre) { $this->nombre_usuario = $nombre; return $this; }

    public function getLineas() { return $this->lineas; }
    public function setLineas($lineas) { $this->lineas = $lineas; return $this; }
    public function addLinea($linea) { $this->lineas[] = $linea; return $this; }
}
?>
