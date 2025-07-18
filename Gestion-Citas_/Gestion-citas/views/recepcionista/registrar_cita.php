<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Nueva Cita - Gestión de Citas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="main-content">
            <h1>Registrar Nueva Cita</h1>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?= htmlspecialchars($error) ?>
                </div>
            <?php endif; ?>

            <?php if (isset($exito)): ?>
                <div class="alert alert-success" role="alert">
                    <?= htmlspecialchars($exito) ?>
                </div>
            <?php endif; ?>

            <!-- Formulario de búsqueda de paciente -->
            <div class="card mb-4">
                <div class="card-header">
                    <h3 class="text-white mb-0">Buscar Paciente</h3>
                </div>
                <div class="card-body">
                    <form method="POST" class="row g-3">
                        <div class="col-md-8">
                            <input type="text" class="form-control" name="filtro_paciente" placeholder="Ingrese DNI o nombre del paciente" required>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary w-100" name="buscar_paciente">Buscar</button>
                        </div>
                    </form>
                </div>
            </div>

            <?php if ($paciente): ?>
                <div class="card mb-4">
                    <div class="card-header">
                        <h3 class="text-white mb-0">Paciente Encontrado</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>DNI</th>
                                        <th>Edad</th>
                                        <th>Teléfono</th>
                                        <th>Dirección</th>
                                        <th>Acción</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><?= htmlspecialchars($paciente['nombre']) ?></td>
                                        <td><?= htmlspecialchars($paciente['apellido']) ?></td>
                                        <td><?= htmlspecialchars($paciente['dni']) ?></td>
                                        <td><?= htmlspecialchars($paciente['edad']) ?> años</td>
                                        <td><?= htmlspecialchars($paciente['telefono']) ?></td>
                                        <td><?= htmlspecialchars($paciente['direccion']) ?></td>
                                        <td>
                                            <?php if (isset($paciente['paciente_id'])): ?>
                                                <a href="index.php?url=recepcionista/registrar_cita_paciente&paciente_id=<?= urlencode($paciente['paciente_id']) ?>" class="btn btn-success btn-sm">
                                                    Crear Cita
                                                </a>
                                            <?php else: ?>
                                                <span class="text-danger">Paciente sin ID</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php elseif (isset($_POST['buscar_paciente'])): ?>
                <div class="card mb-4">
                    <div class="card-body text-center">
                        <h5 class="text-warning">No se encontró al paciente</h5>
                        <p class="text-muted">¿Desea crear una nueva cuenta de paciente?</p>
                        <a href="index.php?url=recepcionista/registrar_paciente" class="btn btn-success">
                            Crear Cuenta
                        </a>
                    </div>
                </div>
            <?php endif; ?>

            <div class="text-center mt-4">
                <a href="index.php?url=recepcionista/dashboard" class="btn btn-secondary">Volver al Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>