<?php
session_start();
include '../database/connect.php';

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit;
}

$id = $_SESSION['usuario']['id'];
$actual = $_POST['actual'];
$nueva = $_POST['nueva'];
$confirmar = $_POST['confirmar'];

if ($nueva !== $confirmar) {
  die("Las contraseñas no coinciden.");
}

$stmt = $conn->prepare("SELECT contraseña FROM usuarios WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$user = $result->fetch_assoc();

// Verifica contraseña actual
if (!password_verify($actual, $user['contraseña'])) {
  die("La contraseña actual es incorrecta.");
}

$nueva_hash = password_hash($nueva, PASSWORD_DEFAULT);
$stmt = $conn->prepare("UPDATE usuarios SET contraseña = ? WHERE id = ?");
$stmt->bind_param("si", $nueva_hash, $id);
$stmt->execute();

echo "<script>alert('Contraseña actualizada correctamente'); window.location='profile.php';</script>";