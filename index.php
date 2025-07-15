<?php
include '../views/includes/header.php';
include 'database/connect.php';

$query = "SELECT nombre_producto, descripcion, imagen, precio_producto FROM productos";
$resultado = $conn->query($query);
?>

<main class="container my-5">
  <h2 class="text-center mb-4">Nuestros Productos</h2>
  <div class="row">
    <?php while($producto = $resultado->fetch_assoc()): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm">
          <img src="/assets/<?php echo $producto['imagen']; ?>" class="card-img-top" alt="Imagen del producto">
          <div class="card-body">
            <h5 class="card-title"><?php echo $producto['nombre_producto']; ?></h5>
            <p class="card-text"><?php echo $producto['descripcion']; ?></p>
            <p class="card-text fw-bold text-end">$<?php echo number_format($producto['precio_producto'], 2); ?></p>
            <a href="cart.php?add=<?php echo $producto['id']; ?>" class="btn btn-custom w-100">Agregar al carrito</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</main>

<?php include '../views/includes/footer.php'; ?>
