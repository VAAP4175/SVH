<?php
include "conexion.php";

$id_materia_asignada = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id_materia_asignada) {
    $nueva_materia = $_POST['id_materia'];
    $conexion->query("UPDATE maestros_materias_perfil SET id_materia = $nueva_materia WHERE id = $id_materia_asignada");
    header("Location: admin_materias.php");
    exit;
}

// Obtener datos actuales
$materia_actual = $conn->query("
    SELECT mm.id_materia, ma.nombre_materia 
    FROM maestros_materias_perfil mm
    JOIN materias ma ON mm.id_materia = ma.id_materia
    WHERE mm.id = $id_materia_asignada
")->fetch_assoc();

$materias_disponibles = $conn->query("SELECT id_materia, nombre_materia FROM materias");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Materia Asignada</title>
</head>
<body>
    <h2>Editar Materia Asignada</h2>
    <form method="post">
        <label>Seleccionar nueva materia:</label>
        <select name="id_materia">
            <?php while ($mat = $materias_disponibles->fetch_assoc()): ?>
                <option value="<?= $mat['id_materia'] ?>" <?= ($mat['id_materia'] == $materia_actual['id_materia']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($mat['nombre_materia']) ?>
                </option>
            <?php endwhile; ?>
        </select>
        <button type="submit">Guardar cambios</button>
    </form>
</body>
</html>
