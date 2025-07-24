<?php
require_once 'Donacion.php';
$donaciones = Donacion::obtenerTodas();
foreach ($donaciones as $d) {
    echo '<div class="col-md-6 mb-3">';
    echo '<div class="card border-success shadow-sm">';
    echo '<div class="card-body">';
    echo '<h5 class="card-title">' . htmlspecialchars($d->donante) . '</h5>';
    echo '<h6 class="card-subtitle mb-2 text-muted">' . htmlspecialchars($d->email) . '</h6>';
    echo '<p class="card-text">';
    echo 'Donó <strong>$' . number_format($d->monto, 2) . '</strong> el <strong>' . htmlspecialchars($d->fecha) . '</strong><br>';
    echo '<em>Proyecto: ' . htmlspecialchars($d->proyecto) . '</em>';
    echo '</p>';
    echo '</div></div></div>';
}
?>

