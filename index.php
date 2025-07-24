<?php
require_once 'Evento.php';
require_once 'Proyecto.php';
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Organización sin fines de lucro</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="style.css">
  <script src="script.js" defer></script>
</head>
<body class="bg-light">
  <div class="container py-4">
    <h1 class="text-center mb-4">Organización sin fines de lucro</h1>
    <ul class="nav nav-tabs mb-3" id="mainTabs">
      <li class="nav-item"><a class="nav-link active" data-bs-toggle="tab" href="#projects-tab">Proyectos</a></li>
      <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#events-tab">Eventos</a></li>
      <li class="nav-item"><a class="nav-link" data-bs-toggle="tab" href="#donations-tab">Donaciones</a></li>
       <li class="nav-item"><a class="nav-link" href="formulario_donacion.php">Carrito 🛒</a></li>
    </ul>
      <div class="tab-content">
        <div class="tab-pane fade show active" id="projects-tab">
          <div class="mb-3">
            <a href="formulario_proyecto.php" class="btn btn-success">Agregar Proyecto</a>
          </div> 
          <div id="projects" class="row">
            <?php
            $proyectos = Proyecto::obtenerTodos();
            foreach ($proyectos as $p) {
              $totalDonaciones = Proyecto::obtenerTotalDonaciones($p->id_proyecto);
              $cantidadDonaciones = Proyecto::contarDonaciones($p->id_proyecto);
              $porcentajeAvance = ($p->presupuesto > 0) ? ($totalDonaciones / $p->presupuesto) * 100 : 0;
              $porcentajeAvance = min($porcentajeAvance, 100);

              echo '<div class="col-md-6">';
              echo '<div class="card mb-3">';
              echo '<div class="card-body">';
              echo '<h5 class="card-title">' . htmlspecialchars($p->nombre) . '</h5>';
              echo '<p class="card-text">' . nl2br(htmlspecialchars($p->descripcion)) . '</p>';
              echo '<p><strong>Presupuesto:</strong> $' . number_format($p->presupuesto, 2) . '</p>';
              echo '<p><strong>Inicio:</strong> ' . htmlspecialchars($p->fecha_inicio) . ' <strong>Fin:</strong> ' . htmlspecialchars($p->fecha_fin) . '</p>';
              echo '<p><strong>Total de donaciones recibidas:</strong> $' . number_format($totalDonaciones, 2) . '</p>';
              echo '<p><strong>Número de donaciones:</strong> ' . intval($cantidadDonaciones) . '</p>';
              
              echo '<div class="mb-2">';
              echo '<div class="progress">';
              echo '<div class="progress-bar bg-success" role="progressbar" style="width: ' . $porcentajeAvance . '%;" aria-valuenow="' . intval($porcentajeAvance) . '" aria-valuemin="0" aria-valuemax="100">';
              echo intval($porcentajeAvance) . '%';
              echo '</div></div></div>';
              
              echo '<button class="btn btn-primary mt-2 btn-donar" ';
              echo 'data-id="' . $p->id_proyecto . '" ';
              echo 'data-nombre="' . htmlspecialchars($p->nombre) . '">';
              echo 'Donar a este proyecto';
              echo '</button>';
              echo '</div></div></div>';
          }
            ?>
        </div>
        </div>
        <div class="tab-pane fade" id="events-tab">
        <div class="mb-3">
          <input type="text" id="events" class="form-control" placeholder="Buscar evento">
        </div>
          <button class="btn btn-primary mb-3" onclick="filtrarEventos()">Buscar</button>
          <a href="formulario_eventos.php" class="btn btn-success mb-3">Agregar nuevo evento</a>
          <div id="results-container" class="list-group">
            <?php            
            $eventos = $_SESSION['eventos'] ?? [];
            foreach ($eventos as $evento) {
                echo '<div class="list-group-item">';
                echo '<strong>' . htmlspecialchars($evento->descripcion) . '</strong><br>';
                echo 'Tipo: ' . htmlspecialchars($evento->tipo) . ' | Lugar: ' . htmlspecialchars($evento->lugar) . '<br>';
                echo 'Fecha: ' . htmlspecialchars($evento->fecha) . ' a las ' . htmlspecialchars($evento->hora);
                echo '</div>';
            }
            ?>
          </div>
      </div>
      <div class="tab-pane fade" id="donations-tab">
        <div id="donations" class="row"></div>
      </div>
    </div>
  </div>
  <div class="notification-area" id="notifications"></div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>