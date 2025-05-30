<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="menu_adm.css">
    <link rel="stylesheet" href="trabla_H.css">
   
</head>
<body>
<header>
<h2>Horario Alumnos</h2>
</header>
<aside class="sidebar">
    <ul class="menu">
        <li class="active" onclick="window.location.href='inicio_adm.php'"><i>🏠</i>Inicio</li>
        <li class="submenu">
            <i>👤</i>Usuarios
            <ul class="submenu-list">
                <li onclick="window.location.href='adm_usuarios.php'"><i>🔐</i>Administrador</li>
                <li onclick="window.location.href='adm_docentes.php'"><i>🖊️</i>Docentes</li>
                <li onclick="window.location.href='adm_alumnos.php'"><i>🎓</i>Alumnos</li>
            </ul>
        </li>

        <li onclick="window.location.href='adm_grupos.php'"><i>📜</i>Grupos</li>
        <li class="submenu">
            <i>📄</i>Horarios
            <ul class="submenu-list">
        <li onclick="window.location.href='adm_horarios.php'"><i>📝</i>Horarios Alumnos</li>
        <li onclick="window.location.href='adm_horarios_D.php'"><i>📑</i>Horarios Docentes</li>
          </ul>
        </li>

        <li class="submenu">
            <i>📚</i>Materias
            <ul class="submenu-list">
        <li onclick="window.location.href='adm_materias.php'"><i>📘</i>Materias</li>
        <li onclick="window.location.href='configurar_horas.php'"><i>⏱</i>Horas por semana</li>
        <li onclick="window.location.href='adm_materias_docente.php'"><i>🗳</i>Solicitud Materias</li>
          </ul>
        </li>
        <li onclick="window.location.href='panel_admin.php'"><i>📂</i>Calificaciones</li>
        <li onclick="window.location.href='index.php'"><i>🔙</i>Salir</li>
    </ul>
</aside>
<main>
<?php
include "conexion.php";

$sql = "SELECT h.hora_inicio, h.hora_fin, h.dia_semana, 
               m.nombre_materia, ma.nombre_completo AS docente, s.numero AS semestre, p.periodo 
        FROM horarios h
        JOIN materias m ON h.id_materia = m.id_materia
        JOIN maestros ma ON h.id_maestro = ma.id_maestro
        JOIN semestres s ON h.id_semestre = s.id_semestre
        JOIN periodo_semestral p ON h.id_periodo = p.id_periodo
        ORDER BY h.dia_semana, h.hora_inicio";

$horarios = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Horarios Académicos</title>
    <style>
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        th { background: #f8f8f8; }
    </style>
</head>
<body>

<h2>Horario Académico</h2>
<table>
    <tr>
        <th>Hora Inicio</th>
        <th>Hora Fin</th>
        <th>Día</th>
        <th>Materia</th>
        <th>Docente</th>
        <th>Semestre</th>
        <th>Periodo</th>
    </tr>
    <?php while ($fila = $horarios->fetch_assoc()): ?>
    <tr>
        <td><?= htmlspecialchars($fila['hora_inicio']) ?></td>
        <td><?= htmlspecialchars($fila['hora_fin']) ?></td>
        <td><?= htmlspecialchars($fila['dia_semana']) ?></td>
        <td><?= htmlspecialchars($fila['nombre_materia']) ?></td>
        <td><?= htmlspecialchars($fila['docente']) ?></td>
        <td><?= htmlspecialchars($fila['semestre']) ?></td>
        <td><?= htmlspecialchars($fila['periodo']) ?></td>
    </tr>
    <?php endwhile; ?>
</table>

</body>
</html>


</main>
<footer>UICSLP © 2025 </footer>
</body>
</html>