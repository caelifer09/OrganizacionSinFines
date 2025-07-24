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
    echo "<p>Sesión inválida. Por favor vuelve a comenzar.</p>";
    exit;
}
$carrito = $_SESSION['carrito_donacion'] ?? [];
if (isset($_GET['eliminar'])) {
    $idEliminar = intval($_GET['eliminar']);
    $_SESSION['carrito_donacion'] = array_filter($carrito, fn($item) => $item['id'] !== $idEliminar);
    header("Location: formulario_donacion.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Donaciones múltiples</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-5">
  <h2 class="mb-4">Formulario de Donación</h2>
  <?php if (empty($carrito)): ?>
    <div class="alert alert-warning">No hay proyectos en tu lista de donación.</div>
    <a href="/app/" class="btn btn-secondary">Volver</a>
    <?php exit(); ?>
  <?php endif; ?>
  <form action="guardar_donacion.php" method="POST">
    <h4>Datos del Donante</h4>
    <div class="row mb-3">
      <div class="col-md-6">
        <label class="form-label">Nombre</label>
        <input type="text" name="nombre" class="form-control" required>
      </div>
      <div class="col-md-6">
        <label class="form-label">Email</label>
        <input type="email" name="email" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Dirección</label>
        <input type="text" name="direccion" class="form-control">
      </div>
      <div class="col-md-6">
        <label class="form-label">Teléfono</label>
        <input type="text" name="telefono" class="form-control">
      </div>
    </div>
    <h4>Proyectos Seleccionados</h4>
    <div class="list-group mb-3">
      <?php foreach ($carrito as $index => $proyecto): ?>
        <div class="list-group-item d-flex justify-content-between align-items-center">
          <div>
            <strong><?= htmlspecialchars($proyecto['nombre']) ?></strong>
            <input type="hidden" name="proyectos[<?= $index ?>][id]" value="<?= $proyecto['id'] ?>">
            <input type="hidden" name="proyectos[<?= $index ?>][nombre]" value="<?= htmlspecialchars($proyecto['nombre']) ?>">
          </div>
          <div class="d-flex align-items-center">
            <label class="me-2">Monto:</label>
            <input type="number" name="proyectos[<?= $index ?>][monto]" value="<?= $proyecto['monto'] ?>" class="form-control me-3" style="width: 100px;" required>
            <a href="?eliminar=<?= $proyecto['id'] ?>" class="btn btn-danger btn-sm">Eliminar</a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="mb-3">
      <label class="form-label">Fecha de donación</label>
      <input type="date" name="fecha" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Finalizar Donaciones</button>
  </form>
</body>
</html>


