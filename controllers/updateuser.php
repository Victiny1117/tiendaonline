<?php
session_start();
include '../database/connect.php';

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit;
}

$nombre = trim($_POST['nombre']);
$apellido = trim($_POST['apellido']);
$id = $_SESSION['usuario']['id'];

$stmt = $conn->prepare("UPDATE usuarios SET nombre = ?, apellido = ? WHERE id = ?");
$stmt->bind_param("ssi", $nombre, $apellido, $id);
$stmt->execute();

// Actualiza la sesion
$_SESSION['usuario']['nombre'] = $nombre;
$_SESSION['usuario']['apellido'] = $apellido;

header("Location: profile.php");