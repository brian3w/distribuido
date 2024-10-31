<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Conexión a la base de datos
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $codigo = $_POST['codigo'];
    $nombre = $_POST['nombre'];
    $cantidad = $_POST['cantidad'];
    $costo = $_POST['costo'];
    $proveedor_id = $_POST['proveedor'];

    // Verificar si el producto ya existe
    $query = "SELECT id, cantidad FROM productos WHERE codigo = '$codigo'";
    $result = mysqli_query($conn, $query);

    if ($result && mysqli_num_rows($result) > 0) {
        $producto = mysqli_fetch_assoc($result);
        $nueva_cantidad = $producto['cantidad'] + $cantidad;

        // Actualizar producto existente
        $update_query = "UPDATE productos 
                         SET cantidad = $nueva_cantidad, 
                             costo = $costo, 
                             proveedor_id = $proveedor_id 
                         WHERE id = {$producto['id']}";
        mysqli_query($conn, $update_query);
        $mensaje = "Cantidad actualizada correctamente.";
    } else {
        // Insertar nuevo producto
        $insert_query = "INSERT INTO productos (codigo, nombre, cantidad, costo, proveedor_id) 
                         VALUES ('$codigo', '$nombre', $cantidad, $costo, $proveedor_id)";
        if (mysqli_query($conn, $insert_query)) {
            $mensaje = "Producto registrado exitosamente.";
        } else {
            $error = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Entrada de Productos</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="inventario.php">Sistema de Inventario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="inventario.php">Regresar</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light" href="logout.php">Cerrar Sesión</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center mb-4">Entrada de Productos</h2>

        <?php if (isset($mensaje)): ?>
            <div class="alert alert-success"><?php echo $mensaje; ?></div>
        <?php elseif (isset($error)): ?>
            <div class="alert alert-danger"><?php echo $error; ?></div>
        <?php endif; ?>

        <form method="POST" action="entradas.php">
            <div class="mb-3">
                <label for="codigo" class="form-label">Código</label>
                <input type="text" class="form-control" id="codigo" name="codigo" required>
            </div>

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre del Producto</label>
                <input type="text" class="form-control" id="nombre" name="nombre" required>
            </div>

            <div class="mb-3">
                <label for="cantidad" class="form-label">Cantidad</label>
                <input type="number" class="form-control" id="cantidad" name="cantidad" required>
            </div>

            <div class="mb-3">
                <label for="costo" class="form-label">Costo</label>
                <input type="number" class="form-control" id="costo" name="costo" step="0.01" required>
            </div>

            <div class="mb-3">
                <label for="proveedor" class="form-label">Proveedor</label>
                <select class="form-control" id="proveedor" name="proveedor" required>
                    <option value="">Seleccione un proveedor</option>
                    <?php
                    $proveedores_result = mysqli_query($conn, "SELECT * FROM proveedores");
                    while ($row = mysqli_fetch_assoc($proveedores_result)) {
                        echo "<option value='{$row['id']}'>{$row['nombre']}</option>";
                    }
                    ?>
                </select>
            </div>

            <button type="submit" class="btn btn-success w-100">Registrar Entrada</button>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
