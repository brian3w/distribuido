<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Incluir la conexión a la base de datos
include 'db.php'; // Asegúrate de que este nombre sea correcto

// Manejo del formulario para agregar un nuevo producto
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $codigo = $_POST['codigo'];
    $categoria = $_POST['categoria'];
    $articulo = $_POST['articulo'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo'];

    // Inserción del nuevo producto en la base de datos
    $sql = "INSERT INTO productos (codigo, categoria, articulo, cantidad, costo) VALUES ('$codigo', '$categoria', '$articulo', $cantidad, $costo)";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='alert alert-success'>Producto agregado exitosamente.</div>";
    } else {
        echo "<div class='alert alert-danger'>Error: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Nuevo Producto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Agregar Nuevo Producto</h2>

    <!-- Formulario para agregar un nuevo producto -->
    <form method="POST">
        <div class="mb-3">
            <label for="codigo" class="form-label">Código</label>
            <input type="text" class="form-control" name="codigo" id="codigo" required>
        </div>
        <div class="mb-3">
            <label for="categoria" class="form-label">Categoría</label>
            <input type="text" class="form-control" name="categoria" id="categoria" required>
        </div>
        <div class="mb-3">
            <label for="articulo" class="form-label">Artículo</label>
            <input type="text" class="form-control" name="articulo" id="articulo" required>
        </div>
        <div class="mb-3">
            <label for="cantidad" class="form-label">Cantidad</label>
            <input type="number" class="form-control" name="cantidad" id="cantidad" required>
        </div>
        <div class="mb-3">
            <label for="costo" class="form-label">Costo</label>
            <input type="text" class="form-control" name="costo" id="costo" required>
        </div>
        <button type="submit" class="btn btn-primary">Agregar Producto</button>
        <a href="inventario.php" class="btn btn-secondary">Regresar</a>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
