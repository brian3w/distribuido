<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

// Conexión a la base de datos
include 'db.php';

// Manejo de operaciones para clientes y proveedores
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_client'])) {
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $sql = "INSERT INTO clientes (nombre, email, telefono) VALUES ('$nombre', '$email', '$telefono')";
        mysqli_query($conn, $sql);
    } elseif (isset($_POST['edit_client'])) {
        $id = $_POST['id'];
        $nombre = $_POST['nombre'];
        $email = $_POST['email'];
        $telefono = $_POST['telefono'];
        $sql = "UPDATE clientes SET nombre='$nombre', email='$email', telefono='$telefono' WHERE id=$id";
        mysqli_query($conn, $sql);
    } elseif (isset($_POST['delete_client'])) {
        $id = $_POST['id'];
        $sql = "DELETE FROM clientes WHERE id=$id";
        mysqli_query($conn, $sql);
    } elseif (isset($_POST['add_provider'])) {
        $nombre = $_POST['nombre_proveedor'];
        $contacto = $_POST['contacto'];
        $telefono = $_POST['telefono_proveedor'];
        $sql = "INSERT INTO proveedores (nombre, contacto, telefono) VALUES ('$nombre', '$contacto', '$telefono')";
        mysqli_query($conn, $sql);
    } elseif (isset($_POST['edit_provider'])) {
        // Editar proveedor
        $id = $_POST['id_proveedor'];
        $nombre = $_POST['nombre_proveedor'];
        $contacto = $_POST['contacto'];
        $telefono = $_POST['telefono_proveedor'];
        $sql = "UPDATE proveedores SET nombre='$nombre', contacto='$contacto', telefono='$telefono' WHERE id=$id";
        mysqli_query($conn, $sql);
    } elseif (isset($_POST['delete_provider'])) {
        // Eliminar proveedor
        $id = $_POST['id_proveedor'];
        $sql = "DELETE FROM proveedores WHERE id=$id";
        mysqli_query($conn, $sql);
    }
}

// Obtener clientes y proveedores existentes
$clientes = mysqli_query($conn, "SELECT * FROM clientes");
$proveedores = mysqli_query($conn, "SELECT * FROM proveedores");
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Clientes y Proveedores</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <h2>Gestión de Clientes y Proveedores</h2>

    <a href="inventario.php" class="btn btn-secondary mb-4">Regresar</a>

    <div class="row">
        <!-- Formulario para Clientes -->
        <div class="col-md-6">
            <h4>Clientes</h4>
            <form method="POST" class="mb-4">
                <input type="hidden" name="id" id="client_id">
                <div class="mb-3">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" class="form-control" name="nombre" id="nombre" required>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" required>
                </div>
                <div class="mb-3">
                    <label for="telefono" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" name="telefono" id="telefono" required>
                </div>
                <button type="submit" name="add_client" class="btn btn-primary">Agregar Cliente</button>
                <button type="submit" name="edit_client" class="btn btn-warning">Editar Cliente</button>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Email</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($clientes)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['email']; ?></td>
                            <td><?php echo $row['telefono']; ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_client" class="btn btn-danger">Eliminar</button>
                                </form>
                                <button class="btn btn-info" onclick="editClient(<?php echo $row['id']; ?>, '<?php echo $row['nombre']; ?>', '<?php echo $row['email']; ?>', '<?php echo $row['telefono']; ?>')">Editar</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>

        <!-- Formulario para Proveedores -->
        <div class="col-md-6">
            <h4>Proveedores</h4>
            <form method="POST" class="mb-4">
                <input type="hidden" name="id_proveedor" id="id_proveedor">
                <div class="mb-3">
                    <label for="nombre_proveedor" class="form-label">Nombre del Proveedor</label>
                    <input type="text" class="form-control" name="nombre_proveedor" id="nombre_proveedor" required>
                </div>
                <div class="mb-3">
                    <label for="contacto" class="form-label">Contacto</label>
                    <input type="text" class="form-control" name="contacto" id="contacto" required>
                </div>
                <div class="mb-3">
                    <label for="telefono_proveedor" class="form-label">Teléfono</label>
                    <input type="text" class="form-control" name="telefono_proveedor" id="telefono_proveedor" required>
                </div>
                <button type="submit" name="add_provider" class="btn btn-success">Agregar Proveedor</button>
                <button type="submit" name="edit_provider" class="btn btn-warning">Editar Proveedor</button>
            </form>

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nombre</th>
                        <th>Contacto</th>
                        <th>Teléfono</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = mysqli_fetch_assoc($proveedores)): ?>
                        <tr>
                            <td><?php echo $row['id']; ?></td>
                            <td><?php echo $row['nombre']; ?></td>
                            <td><?php echo $row['contacto']; ?></td>
                            <td><?php echo $row['telefono']; ?></td>
                            <td>
                                <form method="POST" style="display:inline;">
                                    <input type="hidden" name="id_proveedor" value="<?php echo $row['id']; ?>">
                                    <button type="submit" name="delete_provider" class="btn btn-danger">Eliminar</button>
                                </form>
                                <button class="btn btn-info" onclick="editProvider(<?php echo $row['id']; ?>, '<?php echo $row['nombre']; ?>', '<?php echo $row['contacto']; ?>', '<?php echo $row['telefono']; ?>')">Editar</button>
                            </td>
                        </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
function editClient(id, nombre, email, telefono) {
    document.getElementById('client_id').value = id;
    document.getElementById('nombre').value = nombre;
    document.getElementById('email').value = email;
    document.getElementById('telefono').value = telefono;
}

function editProvider(id, nombre, contacto, telefono) {
    document.getElementById('id_proveedor').value = id;
    document.getElementById('nombre_proveedor').value = nombre;
    document.getElementById('contacto').value = contacto;
    document.getElementById('telefono_proveedor').value = telefono;
}
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>




