<?php
ini_set('display_errors', 1);
error_reporting(E_ALL);
include "conexion.php";

// Obtener solicitudes de materias pendientes con la tabla `maestros`
$sql = "SELECT mm.id, m.nombre_completo AS docente, ma.nombre_materia
        FROM maestros_materias_perfil mm
        JOIN maestros m ON mm.id_maestro = m.id_maestro
        JOIN materias ma ON mm.id_materia = ma.id_materia
        WHERE mm.estado = 'pendiente'";
        

$solicitudes = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Aprobación de Materias</title>
  <style>
    table { width: 100%; border-collapse: collapse; }
    th, td { padding: 10px; border: 1px solid #ddd; }
    th { background: #f8f8f8; }
    a { padding: 5px 10px; display: inline-block; text-decoration: none; }
  </style>
</head>
<body>
    <main> 
  <h2>Solicitudes de Materias</h2>
  <table>
    <tr>
      <th>Docente</th>
      <th>Materia</th>
      <th>Acciones</th>
    </tr>
    <?php while ($fila = $solicitudes->fetch_assoc()): ?>
    <tr>
      <td><?= htmlspecialchars($fila['docente']) ?></td>
      <td><?= htmlspecialchars($fila['nombre_materia']) ?></td>
      <td>
       <a href="gestionar_materia.php?id=<?= $fila['id'] ?>&accion=aprobado">✅ Aprobar</a>
<a href="gestionar_materia.php?id=<?= $fila['id'] ?>&accion=rechazado">❌ Rechazar</a>

      </td>
    </tr>
    <?php endwhile; ?>
  </table>
  <h2>Materias Asignadas</h2>
<table>
    <tr>
        <th>Docente</th>
        <th>Materia</th>
        <th>Acciones</th>
    </tr>
    <?php
    $materias_aprobadas = $conn->query("
        SELECT mm.id, m.nombre_completo AS docente, ma.nombre_materia
        FROM maestros_materias_perfil mm
        JOIN maestros m ON mm.id_maestro = m.id_maestro
        JOIN materias ma ON mm.id_materia = ma.id_materia
        WHERE mm.estado = 'aprobado'
    ");

    while ($fila = $materias_aprobadas->fetch_assoc()):
    ?>
    <tr>
        <td><?= htmlspecialchars($fila['docente']) ?></td>
        <td><?= htmlspecialchars($fila['nombre_materia']) ?></td>
        <td>
            <a href="editar_materia.php?id=<?= $fila['id'] ?>">✏️ Editar</a>
            <a href="gestionar_materia.php?id=<?= $fila['id'] ?>&accion=rechazado">❌ Eliminar</a>
        </td>
    </tr>
    <?php endwhile; ?>
    
</table>
</main>
</body>
</html>
