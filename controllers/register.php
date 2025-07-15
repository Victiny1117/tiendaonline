<?php
include '../database/connect.php';

$nombre     = $_POST['nombre'];
$apellido   = $_POST['apellido'];
$correo     = $_POST['correo'];
$password   = $_POST['password'];
$confirmar  = $_POST['confirmar'];

if ($password !== $confirmar) {
    echo "Las contraseñas no coinciden.";
    exit;
}

$hash = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO usuarios (nombre, apellido, correo, contraseña, nivel) VALUES (?, ?, ?, ?, 'usuario')";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ssss", $nombre, $apellido, $correo, $hash);
$stmt->execute();

header("Location: ../views/login.php");
?>