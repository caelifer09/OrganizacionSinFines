<?php
class Evento {
    public $descripcion;
    public $tipo;
    public $lugar;
    public $fecha;
    public $hora;
    public function __construct($descripcion, $tipo, $lugar, $fecha, $hora) {
        $this->descripcion = $descripcion;
        $this->tipo = $tipo;
        $this->lugar = $lugar;
        $this->fecha = $fecha;
        $this->hora = $hora;
    }
}
?>
