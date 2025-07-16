<?php
session_start();
include '../database/connect.php';

$id_factura = $_GET['id'] ?? 0;

$stmt = $conn->prepare("
  SELECT f.fecha, f.precio_final, u.nombre, u.apellido
  FROM factura f
  JOIN usuarios u ON f.usuario_id = u.id
  WHERE f.id = ?
");
$stmt->bind_param("i", $id_factura);
$stmt->execute();
$factura = $stmt->get_result()->fetch_assoc();

if (!$factura) {
  echo "<div class='alert alert-danger'>Factura no encontrada.</div>";
  exit;
}

$stmt2 = $conn->prepare("
  SELECT p.nombre_producto, p.precio_producto, c.cantidad
  FROM carrito c
  JOIN productos p ON p.id = c.producto_id
  JOIN factura f ON f.id_carrito = c.id
  WHERE f.id = ?
");
$stmt2->bind_param("i", $id_factura);
$stmt2->execute();
$items = $stmt2->get_result();
?>

<main class="container my-5">
  <h2 class="text-center mb-4">Factura #<?= $id_factura; ?></h2>
  <p><strong>Fecha:</strong> <?= date('d/m/Y H:i', strtotime($factura['fecha'])); ?></p>
  <p><strong>Cliente:</strong> <?= $factura['nombre'] . ' ' . $factura['apellido']; ?></p>

  <table class="table table-bordered mt-4">
    <thead>
      <tr>
        <th>Producto</th>
        <th>Precio</th>
        <th>Cantidad</th>
        <th>Subtotal</th>
      </tr>
    </thead>
    <tbody>
      <?php while($item = $items->fetch_assoc()): ?>
        <tr>
          <td><?= $item['nombre_producto']; ?></td>
          <td>$<?= number_format($item['precio_producto'], 2); ?></td>
          <td><?= $item['cantidad']; ?></td>
          <td>$<?= number_format($item['precio_producto'] * $item['cantidad'], 2); ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
    <tfoot>
      <tr>
        <th colspan="3" class="text-end">Total</th>
        <th>$<?= number_format($factura['precio_final'], 2); ?></th>
      </tr>
    </tfoot>
  </table>
</main>