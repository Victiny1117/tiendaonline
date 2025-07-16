<?php
session_start();
include '../database/connect.php';

if (!isset($_SESSION['usuario']) || !isset($_GET['add'])) {
  header("Location: ../views/login.php");
  exit;
}

$usuario_id  = $_SESSION['usuario']['id'];
$producto_id = intval($_GET['add']);

// Verificar si ya esta en el carrito
$check = $conn->prepare("SELECT id FROM carrito WHERE usuario_id = ? AND producto_id = ?");
$check->bind_param("ii", $usuario_id, $producto_id);
$check->execute();
$result = $check->get_result();

if ($result->num_rows > 0) {

  // Si ya existe, incrementar cantidad
  $update = $conn->prepare("UPDATE carrito SET cantidad = cantidad + 1 WHERE usuario_id = ? AND producto_id = ?");
  $update->bind_param("ii", $usuario_id, $producto_id);
  $update->execute();

} else {

  // Si no existe, insertarlo
  $insert = $conn->prepare("INSERT INTO carrito (usuario_id, producto_id) VALUES (?, ?)");
  $insert->bind_param("ii", $usuario_id, $producto_id);
  $insert->execute();
}

header("Location: ../views/cart.php");