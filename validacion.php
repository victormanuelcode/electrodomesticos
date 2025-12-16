<?php
$usuarioValido = 'admin';
$contrasenaValida = '12345';

$usuario = $_POST['usuario'] ?? '';
$contrasena = $_POST['contrasena'] ?? '';

if ($usuario === $usuarioValido && $contrasena === $contrasenaValida) {
  header("Location: index.php?mensaje=" . urlencode("Inicio de sesión exitoso"));
} else {
  header("Location: index.php?mensaje=" . urlencode("Usuario y/o contraseña incorrecta"));
}
exit;
