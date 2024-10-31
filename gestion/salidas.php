<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Incluir la conexión a la base de datos
include 'db.php'; // Asegúrate de que este nombre sea correcto

// Manejo del formulario para registrar una salida
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo'];
    $cantidad_salida = $_POST['cantidad'];

    // Verificar si el producto existe y la cantidad es suficiente
    $sql = "SELECT cantidad FROM productos WHERE codigo = '$codigo'";
    $result = mysqli_query($conn, $sql);

    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $cantidad_actual = $row['cantidad'];

        if ($cantidad_salida <= $cantidad_actual) {
            // Actualizar la cantidad en la base de datos
            $nueva_cantidad = $cantidad_actual - $cantidad_salida;
            $update_sql = "UPDATE productos SET cantidad = $nueva_cantidad WHERE codigo = '$codigo'";
            if (mysqli_query($conn, $update_sql)) {
                echo "<div class='alert alert-success'>Salida registrada exitosamente. Nueva cantidad: $nueva_cantidad</div>";
            } else {
                echo "<div class='alert alert-danger'>Error al actualizar la cantidad: " . mysqli_error($conn) . "</div>";
            }
        } else {
            echo "<div class='alert alert-danger'>No hay suficiente cantidad disponible.</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>El producto no existe.</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Salida de Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Registrar Salida de Producto</h2>

    <!-- Formulario para registrar una salida de producto -->
    <form method="POST">
        <div class="mb-3">
            <label for="codigo" class="form-label">Código del Producto</label>
            <input type="text" class="form-control" name="codigo" id="codigo" required>
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad a Vender</label>
            <input type="number" class="form-control" name="cantidad" id="cantidad" required>
        </div>
        <button type="submit" class="btn btn-danger">Registrar Salida</button>
        <a href="inventario.php" class="btn btn-secondary">Regresar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
