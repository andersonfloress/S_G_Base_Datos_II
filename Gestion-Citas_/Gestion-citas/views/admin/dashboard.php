<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administración - Gestión de Citas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="main-content">
            <h1 class="text-gradient">Panel de Administración</h1>
            
            <div class="card dashboard-card mb-4">
                <div class="card-body">
                    <h4 class="text-primary">Bienvenido, <?= htmlspecialchars($_SESSION['usuario_nombre']) ?></h4>
                    <p class="text-muted">Gestiona el sistema desde este panel de control</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">👥 Usuarios</h5>
                            <p class="card-text">Gestiona todos los usuarios del sistema</p>
                            <div class="d-grid gap-2">
                                <a href="index.php?url=admin/usuarios" class="btn btn-primary">Gestionar Usuarios</a>
                                <a href="index.php?url=admin/crearUsuario" class="btn btn-success">Crear Usuario</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">🏥 Especialidades</h5>
                            <p class="card-text">Administra especialidades médicas</p>
                            <div class="d-grid">
                                <a href="index.php?url=admin/especialidades" class="btn btn-primary">Gestionar Especialidades</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">📊 Reportes</h5>
                            <p class="card-text">Visualiza estadísticas del sistema</p>
                            <div class="d-grid">
                                <a href="index.php?url=admin/reportes" class="btn btn-info">Ver Reportes</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="index.php?url=usuario/logout" class="btn btn-danger">Cerrar Sesión</a>
            </div>
        </div>
    </div>
</body>
</html>