<?php
session_start();
include '../database/connect.php';

if (!isset($_SESSION['usuario'])) {
  header("Location: ../views/login.php");
  exit;
}

$usuario_id = $_SESSION['usuario']['id'];
$id_carrito = $_GET['carrito_id'];
$precio_final = $_GET['total'];

$stmt = $conn->prepare("INSERT INTO factura (id_carrito, usuario_id, precio_final) VALUES (?, ?, ?)");
$stmt->bind_param("iid", $id_carrito, $usuario_id, $precio_final);
$stmt->execute();

$factura_id = $conn->insert_id;
header("Location: ../views/getbill.php?id=" . $factura_id);