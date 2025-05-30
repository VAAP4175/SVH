<?php
session_start();
if (!isset($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit();
}

include("conexion.php");

$sql = "
SELECT 
    ac.id_archivo,
    ac.id_grupo,
    ac.id_materia,
    ac.id_maestro,
    g.nombre_grupo,
    m.nombre_materia,
    ma.nombre_completo AS maestro,
    ac.parcial,
    ac.nombre_excel,
    ac.fecha_subida
FROM archivos_calificaciones ac
JOIN grupos g ON ac.id_grupo = g.id_grupo
JOIN materias m ON ac.id_materia = m.id_materia
JOIN maestros ma ON ac.id_maestro = ma.id_maestro
ORDER BY ac.fecha_subida DESC
";

$resultado = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Administrador</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="adm.css">
    <link rel="stylesheet" href="../menu_adm.css">
    <link rel="stylesheet" href="../tabla.css">
</head>
<body>
    <header><h2>Calificaciones</h2></header>
    <aside class="sidebar">
    <ul class="menu">
        <li class="active" onclick="window.location.href='../inicio_adm.php'"><i>🏠</i>Inicio</li>
        <li class="submenu">
            <i>👤</i>Usuarios
            <ul class="submenu-list">
                <li onclick="window.location.href='../adm_usuarios.php'"><i>🔐</i>Administrador</li>
                <li onclick="window.location.href='../adm_docentes.php'"><i>🖊️</i>Docentes</li>
                <li onclick="window.location.href='../adm_alumnos.php'"><i>🎓</i>Alumnos</li>
            </ul>
        </li>

        <li onclick="window.location.href='../adm_grupos.php'"><i>📜</i>Grupos</li>
        <li class="submenu">
            <i>📄</i>Horarios
            <ul class="submenu-list">
        <li onclick="window.location.href='../adm_horarios.php'"><i>📝</i>Horarios Alumnos</li>
        <li onclick="window.location.href='../adm_horarios_D.php'"><i>📑</i>Horarios Docentes</li>
        <li onclick="window.location.href='../adm_materias.php'"><i>📚</i>Materias</li>
          </ul>
        </li>
        <li onclick="window.location.href='SC/panel_admin.php'"><i>📜</i>Calificaciones</li>
        <li onclick="window.location.href='../index.php'"><i>🔙</i>Salir</li>
    </ul>
</aside>
    <main>
    <div class="contenedor2">
        <h2>📂 Archivos de Calificaciones Subidos</h2>

        <table>
            <tr>
                <th>Grupo</th>
                <th>Materia</th>
                <th>Maestro</th>
                <th>Parcial</th>
                <th>Fecha de Subida</th>
                <th>Archivo</th>
                <th>Acciones</th>
            </tr>

            <?php if ($resultado->num_rows > 0): ?>
                <?php while ($row = $resultado->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($row['nombre_grupo']); ?></td>
                        <td><?php echo htmlspecialchars($row['nombre_materia']); ?></td>
                        <td><?php echo htmlspecialchars($row['maestro']); ?></td>
                        <td><?php echo $row['parcial']; ?></td>
                        <td><?php echo $row['fecha_subida']; ?></td>
                        <td>
                            <a class="descargar" href="archivos_excel/<?php echo $row['nombre_excel']; ?>" download>
                                📥 Descargar
                            </a>
                        </td>
                        <td class="acciones">
                            <a class="editar" href="editar_calificacion.php?id_grupo=<?php echo $row['id_grupo']; ?>&id_materia=<?php echo $row['id_materia']; ?>&id_maestro=<?php echo $row['id_maestro']; ?>&parcial=<?php echo $row['parcial']; ?>">
                                ✏️ Editar
                            </a>
                            <a class="eliminar" href="eliminar_archivo.php?id=<?php echo $row['id_archivo']; ?>"
                               onclick="return confirm('¿Eliminar este archivo y sus calificaciones asociadas?')">
                                🗑️ Eliminar
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            <?php else: ?>
                <tr><td colspan="7">No hay archivos registrados.</td></tr>
            <?php endif; ?>
        </table>

        <form action="logout.php" method="post" class="logout">
            <button type="submit">🚪 Cerrar Sesión</button>
        </form>
    </div>
    </main>
    <footer>UICSLP © 2025 </footer>
</body>
</html>