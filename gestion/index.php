<?php
session_start();
include('db.php');  // Conexión a la base de datos

// Inicio de sesión
if (isset($_POST['login'])) {
    $usuario = $_POST['usuario'];
    $password = $_POST['password'];

    $query = $conn->prepare("SELECT * FROM usuarios WHERE usuario = ? AND password = ?");
    $query->bind_param("ss", $usuario, $password);
    $query->execute();
    $result = $query->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $_SESSION['usuario'] = $usuario;
        $_SESSION['rol'] = $row['rol'];  // Guardar el rol en la sesión

        header('Location: inventario.php');  // Redirigir según el rol si se requiere
        exit();
    } else {
        $error = "Usuario o contraseña incorrectos.";
    }
}

// Registro de nuevo usuario (disponible para todos los usuarios)
if (isset($_POST['register_user'])) {
    $nuevo_usuario = $_POST['nuevo_usuario'];
    $nuevo_password = $_POST['nuevo_password'];
    $rol = $_POST['rol'];

    $query = $conn->prepare("INSERT INTO usuarios (usuario, password, rol) VALUES (?, ?, ?)");
    $query->bind_param("sss", $nuevo_usuario, $nuevo_password, $rol);
    if ($query->execute()) {
        $success = "Usuario registrado con éxito.";
    } else {
        $error = "Error al registrar el usuario.";
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de Sesión</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f0f2f5;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 400px;
            padding: 30px;
            background-color: white;
            box-shadow: 0 0 15px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <!-- Inicio de Sesión -->
    <div class="container">
        <h2 class="text-center mb-4">Inicio de Sesión</h2>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="usuario" class="form-label">Usuario</label>
                <input type="text" name="usuario" id="usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="password" class="form-label">Contraseña</label>
                <input type="password" name="password" id="password" class="form-control" required>
            </div>
            <button type="submit" name="login" class="btn btn-primary w-100">Ingresar</button>
        </form>
    </div>

    <!-- Registro de Nuevo Usuario -->
    <div class="container">
        <h2 class="text-center mb-4">Registrar Nuevo Usuario</h2>
        <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <form method="POST">
            <div class="mb-3">
                <label for="nuevo_usuario" class="form-label">Nuevo Usuario</label>
                <input type="text" name="nuevo_usuario" id="nuevo_usuario" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="nuevo_password" class="form-label">Contraseña</label>
                <input type="password" name="nuevo_password" id="nuevo_password" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="rol" class="form-label">Rol</label>
                <select name="rol" id="rol" class="form-control" required>
                    <option value="administrador">Administrador</option>
                    <option value="editor">Editor</option>
                    <option value="visualizador">Visualizador</option>
                </select>
            </div>
            <button type="submit" name="register_user" class="btn btn-success w-100">Registrar Usuario</button>
        </form>
    </div>
</body>
</html>


