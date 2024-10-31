<?php
session_start();
session_destroy(); // Eliminar sesión
header('Location: index.php'); // Redirigir al inicio
exit();
?>
