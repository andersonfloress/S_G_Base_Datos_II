<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Recepcionista - Gestión de Citas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="main-content">
            <h1 class="text-gradient">Panel de Recepcionista</h1>
            
            <div class="card dashboard-card mb-4">
                <div class="card-body">
                    <h4 class="text-primary">Bienvenido, <?php echo htmlspecialchars($_SESSION['usuario_nombre']); ?></h4>
                    <p class="text-muted">Gestiona las citas y pacientes del centro médico</p>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">📅 Citas</h5>
                            <p class="card-text">Administra las citas médicas</p>
                            <div class="d-grid gap-2">
                                <a href="index.php?url=recepcionista/gestionar_citas" class="btn btn-primary">Gestionar Citas</a>
                                <a href="index.php?url=recepcionista/registrar_cita" class="btn btn-success">Nueva Cita</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">👥 Pacientes</h5>
                            <p class="card-text">Gestiona la información de pacientes</p>
                            <div class="d-grid">
                                <a href="index.php?url=recepcionista/ver_pacientes" class="btn btn-info">Ver Pacientes</a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card dashboard-card h-100">
                        <div class="card-body text-center">
                            <h5 class="card-title text-primary">⏰ Horarios</h5>
                            <p class="card-text">Registra entrada y salida</p>
                            <div class="d-grid gap-2">
                               <form method="post" action="index.php?url=registroHorario/marcarEntrada">
                                    <button type="submit" class="btn btn-success w-100">Registrar Entrada</button>
                                </form>
                                <form method="post" action="index.php?url=registroHorario/marcarSalida">
                                    <button type="submit" class="btn btn-warning w-100">Registrar Salida</button>
                                </form>
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