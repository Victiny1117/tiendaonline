<?php include '../views/includes/header.php'; ?>

<main class="container my-5">
  <h2 class="text-center mb-4">Inicio de Sesión</h2>
  <form action="../controllers/login.php" method="POST" class="mx-auto" style="max-width: 500px;">
    <input type="email" name="correo" class="form-control mb-3" placeholder="Correo" required>
    <input type="password" name="password" class="form-control mb-3" placeholder="Contraseña" required>
    <button type="submit" class="btn btn-custom w-100">Ingresar</button>
  </form>
</main>

<?php include '../views/includes/footer.php'; ?>