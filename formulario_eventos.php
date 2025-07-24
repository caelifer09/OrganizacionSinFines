<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Agregar eventos</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <script src="script.js" defer></script>
</head>
<body class="bg-light">
  <form method="POST" action="registrar_evento.php" class="p-3">
    <div class="mb-3">
      <label for="descripcion" class="form-label">Descripción del evento</label>
      <input type="text" name="descripcion" id="descripcion" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="tipo" class="form-label">Tipo de evento</label>
      <input type="text" name="tipo" id="tipo" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="lugar" class="form-label">Lugar</label>
      <input type="text" name="lugar" id="lugar" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="fecha" class="form-label">Fecha</label>
      <input type="date" name="fecha" id="fecha" class="form-control" required>
    </div>
    <div class="mb-3">
      <label for="hora" class="form-label">Hora</label>
      <input type="time" name="hora" id="hora" class="form-control" required>
    </div>
    <button type="submit" class="btn btn-success">Registrar Evento</button>    
    <a href="index.php?tab=events-tab" class="btn btn-secondary ms-2">Volver</a>
  </form>
</body>
</html>
