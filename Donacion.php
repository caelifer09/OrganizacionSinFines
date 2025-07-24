<?php
require_once 'config.php';
class Donacion {
    private static function conectar() {
        global $host, $dbname, $user, $password;
        return new PDO("pgsql:host=$host;dbname=$dbname", $user, $password);
    }
    public static function obtenerTodas() {
        $db = self::conectar();
        $stmt = $db->query("
            SELECT d.id_donacion, d.monto, d.fecha, p.nombre AS proyecto, don.nombre AS donante, don.email
            FROM donacion d
            JOIN proyecto p ON d.id_proyecto = p.id_proyecto
            JOIN donante don ON d.id_donante = don.id_donante
            ORDER BY d.fecha DESC
        ");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
}
?>
