<?php
session_set_cookie_params([
    'lifetime' => 1800,
    'path' => '/',
    'secure' => true,
    'httponly' => true,
    'samesite' => 'Strict'
]);
session_start();
if (!isset($_SESSION['ip_address']) || $_SESSION['ip_address'] !== $_SERVER['REMOTE_ADDR'] || $_SESSION['user_agent'] !== $_SERVER['HTTP_USER_AGENT']) {
    session_destroy();
    echo "<p>Sesión inválida. Por favor vuelve a comenzar.</p>";
    exit;
}
require_once 'config.php';
try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    if (
        empty($_POST['nombre']) || empty($_POST['fecha']) ||
        !isset($_POST['proyectos']) || !is_array($_POST['proyectos'])
    ) {
        throw new Exception("Faltan datos obligatorios.");
    }
    $nombre = isset($_POST['nombre']) ? trim(strip_tags($_POST['nombre'])) : null;
    $email = isset($_POST['email']) ? filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL) : null;
    $direccion = isset($_POST['direccion']) ? trim(strip_tags($_POST['direccion'])) : null;
    $telefono = isset($_POST['telefono']) ? trim(strip_tags($_POST['telefono'])) : null;
    $fecha = isset($_POST['fecha']) ? $_POST['fecha'] : null;
    $proyectos = isset($_POST['proyectos']) ? $_POST['proyectos'] : [];
    function esFechaValida($fecha) {
        $d = DateTime::createFromFormat('Y-m-d', $fecha);
        return $d && $d->format('Y-m-d') === $fecha;
    }
    if (!$nombre || !$fecha || !is_array($proyectos) || !esFechaValida($fecha)) {
        die("Datos inválidos");
    }
    try {
        $pdo->beginTransaction();
        $stmtDonante = $pdo->prepare("INSERT INTO donante (nombre, email, direccion, telefono) VALUES (?, ?, ?, ?) RETURNING id_donante");
        $stmtDonante->execute([$nombre, $email, $direccion, $telefono]);
        $idDonante = $stmtDonante->fetchColumn();
        $stmtDonacion = $pdo->prepare("INSERT INTO donacion (monto, fecha, id_proyecto, id_donante) VALUES (?, ?, ?, ?)");
        foreach ($proyectos as $p) {
            if (!isset($p['monto'], $p['id'])) {
                continue;
            }
            $monto = floatval($p['monto']);
            $idProyecto = intval($p['id']);
            if ($monto > 0 && $idProyecto > 0) {
                $stmtDonacion->execute([$monto, $fecha, $idProyecto, $idDonante]);
            }
        }
        $pdo->commit();
    } catch (Exception $e) {
        $pdo->rollBack();
        die("Error al registrar la donación: " . $e->getMessage());
    }
    unset($_SESSION['carrito_donacion']);
    echo "<div style='padding:20px;font-family:sans-serif;'>";
    echo "<h2>Gracias por tu donación, $nombre 🎉</h2>";
    echo "<p>Tu aporte se ha registrado con éxito para " . count($proyectos) . " proyecto(s).</p>";
    echo "<a href='/app/'>Volver al inicio</a>";
    echo "</div>";
} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo "<p>Error: " . $e->getMessage() . "</p>";
}

