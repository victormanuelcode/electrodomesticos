<?php
$mensaje = isset($_GET['mensaje']) ? $_GET['mensaje'] : '';
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Login Gotas de Agua</title>
  <link rel="stylesheet" href="estilos.css">
</head>
<body>
  <!-- Fondo con gotas animadas -->
  <div class="fondo">
    <?php for ($i = 0; $i < 30; $i++): ?>
      <div class="gota" style="left: <?= rand(0, 100) ?>%; animation-delay: <?= rand(0, 10) / 10 ?>s; animation-duration: <?= rand(5, 10) ?>s;"></div>
    <?php endfor; ?>
  </div>

  <div class="container">
    <form class="login-box" action="validacion.php" method="POST">
      <h2>Iniciar Sesión</h2>
      <input type="text" name="usuario" placeholder="Usuario" required>
      <input type="password" name="contrasena" placeholder="Contraseña" required>
      <button type="submit">Ingresar</button>
    </form>
  </div>

  <?php if ($mensaje): ?>
    <div class="modal">
      <div class="modal-content">
        <p><?= htmlspecialchars($mensaje) ?></p>
      </div>
      <meta http-equiv="refresh" content="3; url=<?= ($mensaje === 'Inicio de sesión exitoso') ? 'inicio.php' : 'index.php' ?>">
    </div>
  <?php endif; ?>
</body>
</html>
