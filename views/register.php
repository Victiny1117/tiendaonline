<?php include '../views/includes/header.php'; ?>

<main class="container my-5">
  <div class="row justify-content-center">
    <div class="col-md-6 col-lg-5">
      <div class="card shadow-sm">
        <div class="card-body">
          <h2 class="text-center mb-4">Registro de Usuario</h2>
          <form action="../controllers/register.php" method="POST">
            <div class="mb-3">
              <label for="nombre" class="form-label">Nombre</label>
              <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="apellido" class="form-label">Apellido</label>
              <input type="text" id="apellido" name="apellido" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="correo" class="form-label">Correo electrónico</label>
              <input type="email" id="correo" name="correo" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="password" class="form-label">Contraseña</label>
              <input type="password" id="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
              <label for="confirmar" class="form-label">Confirmar contraseña</label>
              <input type="password" id="confirmar" name="confirmar" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-custom w-100">Registrarse</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</main>

<?php include '../views/includes/footer.php'; ?>
