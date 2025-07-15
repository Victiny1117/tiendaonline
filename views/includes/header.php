<?php
session_start();
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>HEIN</title>

  <link rel="icon" href="../assets/images/favicon.ico" type="image/x-icon">

  <link href="../css/bootstrap.min.css" rel="stylesheet">

  <link href="../assets/css/styles.css" rel="stylesheet">

  <style>
    body {
      background-color: #FFFFFF;
    }

    .btn-custom {
      background-color: #212529;
      color: #fff;
      border: none;
    }

    .btn-custom:hover {
      background-color: #343A40;
      color: #fff;
    }

    header {
      background-color: #E9F1FA;
    }
  </style>
</head>
<body>

<header class="py-3">
  <div class="container d-flex justify-content-between align-items-center">
    <a href="../index.php">
      <img src="../assets/images/logo.png" alt="Logo" style="height: 50px;">
    </a>

    <!-- Navegacion -->
    <nav class="d-flex flex-wrap gap-2">
      <a href="../views/products.php" class="btn btn-custom">Productos</a>
      <a href="../views/search.php" class="btn btn-custom">Buscar</a>
      <a href="../views/cart.php" class="btn btn-custom">Carrito</a>
      <a href="../views/profile.php" class="btn btn-custom">Mi Perfil</a>

      <?php if (!isset($_SESSION['usuario'])): ?>
        <a href="../views/login.php" class="btn btn-custom">Iniciar Sesión</a>
        <a href="../views/register.php" class="btn btn-custom">Registrarse</a>
      <?php else: ?>
        <a href="../controllers/logout.php" class="btn btn-custom">Cerrar Sesión</a>
      <?php endif; ?>
    </nav>
  </div>
</header>