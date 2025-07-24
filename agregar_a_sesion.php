<?php
session_set_cookie_params([
    'lifetime' => 1800,
    'path' => '/',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
if (!isset($_SESSION['ip_address'])) {
    $_SESSION['ip_address'] = $_SERVER['REMOTE_ADDR'];
    $_SESSION['user_agent'] = $_SERVER['HTTP_USER_AGENT'];
} elseif ($_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    session_destroy();
    echo json_encode(['status' => 'invalid_session']);
    exit;
}
session_regenerate_id(true);
header('Content-Type: application/json');
if (isset($_POST['id']) && isset($_POST['nombre'])) {
    $id = intval($_POST['id']);
    $nombre = $_POST['nombre'];
    if (!isset($_SESSION['carrito_donacion'])) {
        $_SESSION['carrito_donacion'] = [];
    }
    foreach ($_SESSION['carrito_donacion'] as $item) {
        if ($item['id'] === $id) {
            echo json_encode(['status' => 'exists']);
            exit;
        }
    }
    $_SESSION['carrito_donacion'][] = [
        'id' => $id,
        'nombre' => $nombre,
        'monto' => 0
    ];
    echo json_encode(['status' => 'added']);
} else {
    echo json_encode(['status' => 'error']);
}