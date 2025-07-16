<?php
include 'includes/header.php';
include '../database/connect.php';

$termino = $_GET['q'] ?? '';
$productos = [];

if ($termino) {
  $query = $conn->prepare("
    SELECT id, nombre_producto, descripcion, precio_producto, imagen 
    FROM productos 
    WHERE nombre_producto LIKE CONCAT('%', ?, '%')
       OR descripcion LIKE CONCAT('%', ?, '%')
  ");
  $query->bind_param("ss", $termino, $termino);
  $query->execute();
  $productos = $query->get_result();
}
?>

<main class="container my-5">
  <h2 class="text-center mb-4">Buscar Productos</h2>

  <form method="GET" class="mb-4 d-flex justify-content-center">
    <input type="text" name="q" class="form-control me-2" placeholder="Buscar por nombre o descripción" value="<?php echo htmlspecialchars($termino); ?>" style="max-width:400px;">
    <button type="submit" class="btn btn-custom">Buscar</button>
  </form>

  <div class="row">
    <?php if ($termino && $productos->num_rows === 0): ?>
      <div class="alert alert-warning text-center">No se encontraron productos para “<?php echo htmlspecialchars($termino); ?>”.</div>
    <?php endif; ?>

    <?php while ($p = $productos->fetch_assoc()): ?>
      <div class="col-md-4 mb-4">
        <div class="card h-100 shadow-sm border-0">
          <img src="/assets/img/productos/<?php echo $p['imagen'] ?: 'default.png'; ?>" class="card-img-top" style="height:200px; object-fit:cover;">
          <div class="card-body">
            <h5 class="card-title"><?php echo $p['nombre_producto']; ?></h5>
            <p class="card-text"><?php echo $p['descripcion']; ?></p>
            <p class="card-text fw-bold text-end text-success">$<?php echo number_format($p['precio_producto'], 2); ?></p>
            <a href="cart.php?add=<?php echo $p['id']; ?>" class="btn btn-custom w-100">Agregar al carrito</a>
          </div>
        </div>
      </div>
    <?php endwhile; ?>
  </div>
</main>

<?php include 'includes/footer.php'; ?>