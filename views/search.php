<?php
include 'includes/header.php';
include '../database/connect.php';

$termino = $_GET['q'] ?? '';
$resultado = null;

if ($termino) {
  $stmt = $conn->prepare("
    SELECT id, nombre_producto, descripcion, imagen, precio_producto
    FROM productos
    WHERE nombre_producto LIKE CONCAT('%', ?, '%')
       OR descripcion LIKE CONCAT('%', ?, '%')
  ");
  $stmt->bind_param("ss", $termino, $termino);
  $stmt->execute();
  $resultado = $stmt->get_result();
}
?>

<main class="container my-5">
  <h2 class="text-center mb-4">Buscar Productos</h2>

  <form method="GET" class="mb-4 d-flex justify-content-center">
    <input type="text" name="q" class="form-control me-2" placeholder="Buscar por nombre o descripción" value="<?= htmlspecialchars($termino); ?>" style="max-width: 400px;">
    <button type="submit" class="btn btn-custom">Buscar</button>
  </form>

  <div class="row">
    <?php if ($termino && $resultado->num_rows === 0): ?>
      <div class="col-12">
        <div class="alert alert-warning text-center">No se encontraron resultados para “<?= htmlspecialchars($termino); ?>”.</div>
      </div>
    <?php endif; ?>

    <?php if ($resultado && $resultado->num_rows > 0): ?>
      <?php while($producto = $resultado->fetch_assoc()): ?>
        <div class="col-md-4 mb-4">
          <div class="card h-100 shadow-sm border-0">
            <img src="/assets/img/productos/<?= $producto['imagen'] ?: 'default.png'; ?>" class="card-img-top" style="height: 200px; object-fit: cover;" alt="Imagen del producto">
            <div class="card-body">
              <h5 class="card-title"><?= $producto['nombre_producto']; ?></h5>
              <p class="card-text"><?= $producto['descripcion']; ?></p>
              <p class="card-text fw-bold text-end text-success">$<?= number_format($producto['precio_producto'], 2); ?></p>
              <a href="/views/cart.php?add=<?= $producto['id']; ?>" class="btn btn-custom w-100">Agregar al carrito</a>
            </div>
          </div>
        </div>
      <?php endwhile; ?>
    <?php endif; ?>
  </div>
</main>

<?php include 'includes/footer.php'; ?>