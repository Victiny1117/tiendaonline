<?php
session_start();
include 'includes/header.php';
include '../database/connect.php';

if (!isset($_SESSION['usuario'])) {
  header("Location: login.php");
  exit;
}

$usuario = $_SESSION['usuario'];

// Obtener facturas del usuario
$stmt = $conn->prepare("
  SELECT id, fecha, precio_final 
  FROM factura 
  WHERE usuario_id = ?
  ORDER BY fecha DESC
");
$stmt->bind_param("i", $usuario['id']);
$stmt->execute();
$facturas = $stmt->get_result();
?>

<main class="container my-5">
  <h2 class="text-center mb-4">Mi Perfil</h2>

  <!-- Informacion personal -->
  <div class="card mb-4 shadow-sm">
    <div class="card-body">
      <h5 class="card-title">Información del usuario</h5>
      <p><strong>Nombre:</strong> <?= htmlspecialchars($usuario['nombre']); ?></p>
      <p><strong>Apellido:</strong> <?= htmlspecialchars($usuario['apellido']); ?></p>
      <p><strong>Correo:</strong> <?= htmlspecialchars($usuario['correo']); ?></p>
    </div>
  </div>

  <!-- Editar nombre y apellido -->
  <div class="card mb-4 shadow-sm">
    <div class="card-body">
      <h5 class="card-title">Editar nombre y apellido</h5>
      <form method="POST" action="../controllers/updateuser.php">
        <div class="mb-3">
          <label for="nombre" class="form-label">Nuevo nombre</label>
          <input type="text" name="nombre" id="nombre" class="form-control" value="<?= htmlspecialchars($usuario['nombre']); ?>" required>
        </div>
        <div class="mb-3">
          <label for="apellido" class="form-label">Nuevo apellido</label>
          <input type="text" name="apellido" id="apellido" class="form-control" value="<?= htmlspecialchars($usuario['apellido']); ?>" required>
        </div>
        <button type="submit" class="btn btn-custom">Actualizar datos</button>
      </form>
    </div>
  </div>

  <!-- Cambiar contraseña -->
  <div class="card mb-4 shadow-sm">
    <div class="card-body">
      <h5 class="card-title">Cambiar contraseña</h5>
      <form method="POST" action="../controllers/changepassword.php">
        <div class="mb-3">
          <label for="actual" class="form-label">Contraseña actual</label>
          <input type="password" name="actual" id="actual" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="nueva" class="form-label">Nueva contraseña</label>
          <input type="password" name="nueva" id="nueva" class="form-control" required>
        </div>
        <div class="mb-3">
          <label for="confirmar" class="form-label">Confirmar nueva contraseña</label>
          <input type="password" name="confirmar" id="confirmar" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-secondary">Actualizar contraseña</button>
      </form>
    </div>
  </div>

  <!-- Historial de facturas -->
  <div class="card shadow-sm">
    <div class="card-body">
      <h5 class="card-title">Mis facturas</h5>
      <?php if ($facturas->num_rows > 0): ?>
        <ul class="list-group list-group-flush">
          <?php while($f = $facturas->fetch_assoc()): ?>
            <li class="list-group-item">
              <strong>#<?= $f['id']; ?></strong> —
              <?= date('d/m/Y', strtotime($f['fecha'])); ?> —
              <span class="text-success fw-bold">$<?= number_format($f['precio_final'], 2); ?></span>
              <a href="getbill.php?id=<?= $f['id']; ?>" class="btn btn-sm btn-outline-primary float-end">Ver factura</a>
            </li>
          <?php endwhile; ?>
        </ul>
      <?php else: ?>
        <p class="text-muted">No tienes facturas registradas todavía.</p>
      <?php endif; ?>
    </div>
  </div>
</main>

<?php include 'includes/footer.php'; ?>