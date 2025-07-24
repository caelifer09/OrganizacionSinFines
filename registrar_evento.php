<?php
require_once 'Evento.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (!isset($_SESSION['eventos'])) {
    $_SESSION['eventos'] = [];
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $evento = new Evento(
        $_POST['descripcion'],
        $_POST['tipo'],
        $_POST['lugar'],
        $_POST['fecha'],
        $_POST['hora']
    );
    $_SESSION['eventos'][] = $evento;
    header('Location: index.php?tab=events-tab');
    exit;
}
?>
