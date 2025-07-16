<?php
session_start();
include 'includes/header.php';
include '../database/connect.php';

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit;
}

$usuario_id = $_SESSION['usuario']['id'];

$query = $conn->prepare("
  SELECT c.id, p.nombre_producto, p.precio_producto, c.cantidad, p.imagen
  FROM carrito c
  JOIN productos p ON c.producto_id = p.id
  WHERE c.usuario_id = ?
");
$query->bind_param("i", $usuario_id);
$query->execute();
$resultado = $query->get_result();
?>

<main class="container my-5">
  <h2 class="text-center mb-4">Tu Carrito</h2>
  
  <?php if ($resultado->num_rows > 0): ?>
    <div class="row">
      <?php $total_general = 0; ?>
      <?php while($item = $resultado->fetch_assoc()): ?>
        <?php $subtotal = $item['precio_producto'] * $item['cantidad']; ?>
        <?php $total_general += $subtotal; ?>
        
        <div class="col-md-6 mb-4">
          <div class="card shadow-sm border-0">
            <div class="row g-0">
              <div class="col-4">
                <img src="/assets/img/productos/<?php echo $item['imagen'] ?: 'default.png'; ?>" class="img-fluid rounded-start" alt="Producto">
              </div>
              <div class="col-8">
                <div class="card-body">
                  <h5 class="card-title"><?php echo $item['nombre_producto']; ?></h5>
                  <p class="card-text mb-1">Cantidad: <?php echo $item['cantidad']; ?></p>
                  <p class="card-text fw-bold text-success">$<?php echo number_format($subtotal, 2); ?></p>
                  <a href="../controllers/cart.php?remove=<?php echo $item['id']; ?>" class="btn btn-danger btn-sm">Eliminar</a>
                </div>
              </div>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    </div>

    <div class="text-end mt-4">
      <h4>Total: <span class="text-success">$<?php echo number_format($total_general, 2); ?></span></h4>
      <a href="checkout.php" class="btn btn-custom">Finalizar compra</a>
    </div>

  <?php else: ?>
    <div class="alert alert-warning text-center">
      Tu carrito está vacío. ¡Agrega productos para comenzar!
    </div>
  <?php endif; ?>
</main>

<?php include 'includes/footer.php'; ?>