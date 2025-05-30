<?php
session_start();
include("conexion.php");

$usuario = $_POST['usuario'];
$contrasena = $_POST['contrasena'];

// Verificar en tabla maestros
$sql_maestro = "SELECT * FROM maestros WHERE usuario = ?";
$stmt = $conn->prepare($sql_maestro);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $maestro = $result->fetch_assoc();
    if (password_verify($contrasena, $maestro['contrasena'])) {
        $_SESSION['id_maestro'] = $maestro['id_maestro'];
        $_SESSION['nombre_completo'] = $maestro['nombre_completo'];
        header("Location: panel_general_maestro.php");
        exit();
    }
}

// Verificar en tabla alumnos
$sql_alumno = "SELECT * FROM alumnos WHERE usuario = ?";
$stmt = $conn->prepare($sql_alumno);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $alumno = $result->fetch_assoc();
    if (password_verify($contrasena, $alumno['contrasena'])) {
        $_SESSION['id_alumno'] = $alumno['id_alumno'];
        $_SESSION['nombre_completo'] = $alumno['nombre_completo'];
        header("Location: panel_general_alumno.php");
        exit();
    }
}


// Verificar en tabla administradores
$sql_admin = "SELECT * FROM administradores WHERE usuario = ?";
$stmt = $conn->prepare($sql_admin);
$stmt->bind_param("s", $usuario);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $admin = $result->fetch_assoc();
    if (password_verify($contrasena, $admin['contrasena'])) {
        $_SESSION['id_admin'] = $admin['id_admin'];
        $_SESSION['nombre_completo'] = $admin['nombre_completo'];

        // Redirección personalizada para el admin con ID 2 y usuario 'vian'
        if ($admin['id_admin'] == 2 && $admin['usuario'] == 'vian') {
            header("Location: inicio_adm.php");
        } else {
            header("Location: inicio_adm.php");
        }
        exit();
    }
}

?>

