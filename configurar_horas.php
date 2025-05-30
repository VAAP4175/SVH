<?php
include "conexion.php";

$id_semestre = $_GET['id_semestre'] ?? ''; // Captura el semestre seleccionado

// Guardar cambios cuando el formulario se envía
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['horas'] as $id_materia => $horas) {
        $conn->query("UPDATE materias_semestre SET horas_semana = $horas WHERE id_materia = $id_materia");
    }
    echo "<p style='color:green;'>Horas actualizadas correctamente.</p>";
}

// Obtener lista de semestres
$semestres = $conn->query("SELECT id_semestre, numero FROM semestres");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Configurar Horas Semanales</title>
</head>
<body>

    <h2>Asignar Horas Semanales por Materia</h2>

    <!-- Selector de Semestre -->
    <form method="get">
        <label><strong>Filtrar por semestre:</strong></label>
        <select name="id_semestre" onchange="this.form.submit()">
            <option value="">-- Selecciona un semestre --</option>
            <?php while ($sem = $semestres->fetch_assoc()): ?>
                <option value="<?= $sem['id_semestre'] ?>" <?= ($id_semestre == $sem['id_semestre']) ? 'selected' : '' ?>>
                    <?= htmlspecialchars($sem['numero']) ?>° semestre
                </option>
            <?php endwhile; ?>
        </select>
    </form>

    <?php
    // Consulta de materias filtradas por semestre
    $sql = "SELECT ms.id_materia, ma.nombre_materia, ms.horas_semana 
            FROM materias_semestre ms 
            JOIN materias ma ON ms.id_materia = ma.id_materia";

    if ($id_semestre) {
        $sql .= " WHERE ms.id_semestre = $id_semestre";
    }

    $materias = $conn->query($sql);
    ?>

    <!-- Tabla de Materias -->
    <form method="post">
        <table>
            <tr>
                <th>Materia</th>
                <th>Horas por Semana</th>
            </tr>
            <?php while ($fila = $materias->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($fila['nombre_materia']) ?></td>
                <td>
                    <input type="number" name="horas[<?= $fila['id_materia'] ?>]" value="<?= $fila['horas_semana'] ?>" min="1">
                </td>
            </tr>
            <?php endwhile; ?>
        </table>
        <button type="submit">Guardar Cambios</button>
    </form>

</body>
</html>
