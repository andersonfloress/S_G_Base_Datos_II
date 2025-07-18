<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Paciente - Gestión de Citas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="main-content">
            <h1 class="text-gradient">Panel de Paciente</h1>
            
            <div class="card dashboard-card mb-4">
                <div class="card-body">
                    <h4 class="text-primary">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h4>
                    <p class="text-muted">Gestiona tus citas y revisa tu información médica</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">👤 Mi Perfil</h5>
                            <p class="card-text">Visualiza y edita tu información personal</p>
                            <div class="d-grid">
                                <a href="index.php?url=paciente/perfil" class="btn btn-primary">Ver Perfil</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">📅 Citas Médicas</h5>
                            <p class="card-text">Reserva y gestiona tus citas</p>
                            <div class="d-grid gap-2">
                                <a href="index.php?url=cita/reservar" class="btn btn-success">Reservar Cita</a>
                                <a href="index.php?url=cita/misCitas" class="btn btn-info">Mis Citas</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">📋 Historial</h5>
                            <p class="card-text">Consulta tu historial clínico</p>
                            <div class="d-grid">
                                <a href="index.php?url=paciente/historial" class="btn btn-primary">Ver Historial</a>
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