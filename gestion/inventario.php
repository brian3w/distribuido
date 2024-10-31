<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Inventario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f4f6f9;
        }
        .navbar {
            margin-bottom: 30px;
        }
        .main-container {
            max-width: 1100px;
            margin: auto;
        }
        .card {
            border: none;
            border-radius: 15px;
            transition: transform 0.2s ease-in-out;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card-icon {
            font-size: 40px;
            margin-bottom: 15px;
        }
        .btn-logout {
            position: absolute;
            right: 15px;
            top: 10px;
        }
    </style>
</head>
<body>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">Sistema de Inventario</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link btn btn-outline-light btn-logout" href="logout.php">Cerrar Sesión <i class="fas fa-sign-out-alt"></i></a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="container main-container">
        <div class="row g-4">

            <!-- Entrada -->
            <div class="col-md-4">
                <div class="card text-center p-4 shadow-sm">
                    <i class="fas fa-box-open card-icon text-success"></i>
                    <h5 class="card-title">Entrada</h5>
                    <p class="card-text">Gestiona las entradas de productos.</p>
                    <a href="entradas.php" class="btn btn-success">Ir a Entradas</a>
                </div>
            </div>

            <!-- Salida -->
            <div class="col-md-4">
                <div class="card text-center p-4 shadow-sm">
                    <i class="fas fa-truck card-icon text-danger"></i>
                    <h5 class="card-title">Salida</h5>
                    <p class="card-text">Gestiona las salidas de productos.</p>
                    <a href="salidas.php" class="btn btn-danger">Ir a Salidas</a>
                </div>
            </div>

            <!-- Nuevo Producto -->
            <div class="col-md-4">
                <div class="card text-center p-4 shadow-sm">
                    <i class="fas fa-plus-circle card-icon text-primary"></i>
                    <h5 class="card-title">Nuevo Producto</h5>
                    <p class="card-text">Agrega nuevos productos al inventario.</p>
                    <a href="nuevo_producto.php" class="btn btn-primary">Agregar Producto</a>
                </div>
            </div>

            <!-- Buscar Código -->
            <!-- Buscar Código -->
<div class="col-md-6">
    <div class="card text-center p-4 shadow-sm">
        <i class="fas fa-search card-icon text-secondary"></i>
        <h5 class="card-title">Buscar Código</h5>
        <p class="card-text">Busca productos por su código único.</p>
        <!-- Formulario para enviar el código al archivo buscar.php -->
        <form action="buscar.php" method="GET">
            <div class="mb-3">
                <input type="text" class="form-control" name="codigo" placeholder="Ingrese el código" required>
            </div>
            <button type="submit" class="btn btn-secondary">Buscar</button>
        </form>
    </div>
</div>


            <!-- Clientes -->
            <div class="col-md-6">
                <div class="card text-center p-4 shadow-sm">
                    <i class="fas fa-users card-icon text-info"></i>
                    <h5 class="card-title">Clientes</h5>
                    <p class="card-text">Gestiona la información de tus clientes.</p>
                    <a href="clientes.php" class="btn btn-info">Ir a Clientes</a>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html



