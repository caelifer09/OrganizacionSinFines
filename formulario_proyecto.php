<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Proyecto</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
<div class="container mt-4">
  <h4>Registrar nuevo proyecto</h4>
  <form method="POST" action="registrar_proyecto.php" class="p-3 border rounded bg-white shadow-sm">
    <div class="mb-3">
      <label for="nombre" class="form-label">Nombre del Proyecto</label>
      <input type="text" name="nombre" id="nombre" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción</label>
      <textarea name="descripcion" id="descripcion" class="form-control"></textarea>
    </div>
    <div class="mb-3">
      <label for="presupuesto" class="form-label">Presupuesto</label>
      <input type="number" name="presupuesto" id="presupuesto" class="form-control" step="0.01">
    </div>
    <div class="mb-3">
      <label for="fecha_inicio" class="form-label">Fecha de inicio</label>
      <input type="date" name="fecha_inicio" id="fecha_inicio" class="form-control">
    </div>
    <div class="mb-3">
      <label for="fecha_fin" class="form-label">Fecha de fin</label>
      <input type="date" name="fecha_fin" id="fecha_fin" class="form-control">
    </div>
    <button type="submit" class="btn btn-success">Registrar Proyecto</button>
    <a href="index.php?tab=projects-tab" class="btn btn-secondary ms-2">Volver</a>
  </form>
</div>
</body>
</html>
