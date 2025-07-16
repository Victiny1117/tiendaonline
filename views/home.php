<?php
include 'includes/header.php';
include '../database/connect.php';

$query = "SELECT id, nombre_producto, descripcion, imagen, precio_producto FROM productos";
$resultado = $conn->query($query);
?>

<main class="container my-5">
  <h2 class="text-center mb-4">Nuestros Productos</h2>
  <div class="row">
    <?php if ($resultado->num_rows > 0): ?>
      <?php while($producto = $resultado->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm border-0">
            <img src="/assets/img/productos/<?php echo $producto['imagen'] ?: 'default.png'; ?>" class="card-img-top" alt="Imagen del producto" style="height: 200px; object-fit: cover;">
            <div class="card-body">
              <h5 class="card-title"><?php echo $producto['nombre_producto']; ?></h5>
              <p class="card-text"><?php echo $producto['descripcion']; ?></p>
              <p class="card-text fw-bold text-end text-success">$<?php echo number_format($producto['precio_producto'], 2); ?></p>
              <a href="/views/cart.php?add=<?php echo $producto['id']; ?>" class="btn btn-custom w-100">Agregar al carrito</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php else: ?>
      <div class="col-12 text-center">
        <div class="alert alert-warning mt-5">
          No hay productos disponibles en este momento.
        </div>
      </div>
    <?php endif; ?>
  </div>
</main>

<?php include 'includes/footer.php'; ?>