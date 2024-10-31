<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Conexión a la base de datos
$servername = "localhost";
$username = "root"; // Tu usuario
$password = "";     // Tu contraseña
$dbname = "inventario"; // Nombre de tu base de datos

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Error de conexión: " . $conn->connect_error);
}

// Verificar si se envió un código desde el formulario
if (isset($_GET['codigo'])) {
    $codigo = $_GET['codigo'];

    // Consulta para buscar el producto por código
    $sql = "SELECT * FROM productos WHERE codigo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $codigo);
    $stmt->execute();
    $result = $stmt->get_result();

    // Verificar si se encontró el producto
    if ($result->num_rows > 0) {
        $producto = $result->fetch_assoc();
    } else {
        $error = "Producto no encontrado.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buscar Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2 class="mb-4">Resultado de la Búsqueda</h2>

    <?php if (isset($producto)): ?>
        <!-- Mostrar los detalles del producto -->
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Producto: <?php echo htmlspecialchars($producto['articulo']); ?></h5>
                <p class="card-text">
                    <strong>Código:</strong> <?php echo htmlspecialchars($producto['codigo']); ?><br>
                    <strong>Categoría:</strong> <?php echo htmlspecialchars($producto['categoria']); ?><br>
                    <strong>Cantidad:</strong> <?php echo htmlspecialchars($producto['cantidad']); ?><br>
                    <strong>Costo:</strong> <?php echo htmlspecialchars($producto['costo']); ?><br>
                </p>
                <a href="inventario.php" class="btn btn-primary">Volver al Inventario</a>
            </div>
        </div>
    <?php elseif (isset($error)): ?>
        <!-- Mostrar mensaje de error si no se encuentra el producto -->
        <div class="alert alert-danger">
            <?php echo $error; ?>
        </div>
        <a href="inventario.php" class="btn btn-primary">Volver al Inventario</a>
    <?php endif; ?>

</div>

</body>
</html>
