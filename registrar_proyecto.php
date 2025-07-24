<?php
require_once 'Proyecto.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nombre = $_POST['nombre'] ?? '';
    $descripcion = $_POST['descripcion'] ?? '';
    $presupuesto = $_POST['presupuesto'] ?? 0;
    $fecha_inicio = $_POST['fecha_inicio'] ?? null;
    $fecha_fin = $_POST['fecha_fin'] ?? null;
    if ($nombre !== '') {
        Proyecto::guardar($nombre, $descripcion, $presupuesto, $fecha_inicio, $fecha_fin);
    }
    header("Location: index.php?tab=projects-tab");
    exit;
}
?>
