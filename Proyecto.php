<?php
require_once 'config.php';
class Proyecto {
    private static function conectar() {
        global $host,$port, $dbname, $user, $password;
        try {
            return new PDO("pgsql:host=$host;port=$port;dbname=$dbname", $user, $password);
        } catch (PDOException $e) {
            die("Error de conexión: " . $e->getMessage());
        }
    }
    public static function guardar($nombre, $descripcion, $presupuesto, $fecha_inicio, $fecha_fin) {
        $db = self::conectar();
        $nombre = trim(strip_tags($nombre));
        $descripcion = trim(strip_tags($descripcion));
        if (!is_numeric($presupuesto) || $presupuesto < 0) {
            return false;
        }
        $fecha_inicio = date('Y-m-d', strtotime($fecha_inicio));
        $fecha_fin = date('Y-m-d', strtotime($fecha_fin));
        if (!self::esFechaValida($fecha_inicio) || !self::esFechaValida($fecha_fin)) {
            return false;
        }
        $stmt = $db->prepare("INSERT INTO proyecto (nombre, descripcion, presupuesto, fecha_inicio, fecha_fin) 
                            VALUES (:nombre, :descripcion, :presupuesto, :fecha_inicio, :fecha_fin)");
        return $stmt->execute([
            ':nombre' => $nombre,
            ':descripcion' => $descripcion,
            ':presupuesto' => $presupuesto,
            ':fecha_inicio' => $fecha_inicio,
            ':fecha_fin' => $fecha_fin
        ]);
    }
    public static function obtenerTodos() {
        $db = self::conectar();
        $stmt = $db->query("SELECT * FROM proyecto ORDER BY id_proyecto DESC");
        return $stmt->fetchAll(PDO::FETCH_OBJ);
        }
        public static function obtenerTotalDonaciones($id_proyecto) {
        $db = self::conectar();
        $stmt = $db->prepare("SELECT COALESCE(SUM(monto), 0) AS total FROM donacion WHERE id_proyecto = :id_proyecto");
        $stmt->execute([':id_proyecto' => $id_proyecto]);
        $resultado = $stmt->fetch(PDO::FETCH_OBJ);
        return $resultado->total;
    }
    public static function contarDonaciones($id_proyecto) {
        $db = self::conectar();
        $stmt = $db->prepare("SELECT COUNT(*) AS cantidad FROM donacion WHERE id_proyecto = :id_proyecto");
        $stmt->execute([':id_proyecto' => $id_proyecto]);
        $resultado = $stmt->fetch(PDO::FETCH_OBJ);
        return $resultado->cantidad;
    }
    private static function esFechaValida($fecha) {
        $d = DateTime::createFromFormat('Y-m-d', $fecha);
        return $d && $d->format('Y-m-d') === $fecha;
    }
}
?>
