<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestionar Citas - Gestión de Citas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="main-content">
            <h1>Gestionar Citas</h1>
            
            <!-- Filtros -->
            <div class="card filter-container">
                <h3>Filtrar Citas</h3>
                <form method="POST" class="row g-3">
                    <div class="col-md-4">
                        <label for="dni" class="form-label">DNI:</label>
                        <input type="text" class="form-control" id="dni" name="dni" placeholder="Ingrese DNI">
                    </div>
                    <div class="col-md-4">
                        <label for="nombre" class="form-label">Nombre:</label>
                        <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese nombre">
                    </div>
                    <div class="col-md-4">
                        <label for="fecha" class="form-label">Fecha:</label>
                        <input type="date" class="form-control" id="fecha" name="fecha">
                    </div>
                    <div class="col-12">
                        <button type="submit" class="btn btn-primary">Filtrar</button>
                        <a href="index.php?url=recepcionista/gestionar_citas" class="btn btn-secondary">Limpiar</a>
                    </div>
                </form>
            </div>

            <!-- Tabla de citas -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-white mb-0">Lista de Citas</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>N°</th>
                                    <th>Paciente</th>
                                    <th>DNI</th>
                                    <th>Especialidad</th>
                                    <th>Fecha</th>
                                    <th>Hora</th>
                                    <th>Motivo</th>
                                    <th>Estado</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (count($citas) > 0): ?>
                                    <?php $n = 1; foreach ($citas as $cita): ?>
                                        <tr>
                                            <td><?= $n++ ?></td>
                                            <td><?= htmlspecialchars($cita['nombre'] . ' ' . $cita['apellido']) ?></td>
                                            <td><?= htmlspecialchars($cita['dni']) ?></td>
                                            <td><?= htmlspecialchars($cita['especialidad']) ?></td>
                                            <td><?= htmlspecialchars($cita['fecha']) ?></td>
                                            <td><?= htmlspecialchars($cita['hora']) ?></td>
                                            <td><?= htmlspecialchars($cita['motivo_cita']) ?></td>
                                            <td>
                                                <?php
                                                $estado = $cita['estado'];
                                                if ($estado == 'pendiente') {
                                                    echo '<span class="estado-pendiente">Pendiente</span>';
                                                } elseif ($estado == 'completada') {
                                                    echo '<span class="estado-completada">Completada</span>';
                                                } elseif ($estado == 'cancelada') {
                                                    echo '<span class="estado-cancelada">Cancelada</span>';
                                                } elseif ($estado == 'atendida') {
                                                    echo '<span class="estado-atendida">Atendida</span>';
                                                } else {
                                                    echo '<span class="badge bg-secondary">' . htmlspecialchars($estado) . '</span>';
                                                }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($cita['estado'] !== 'cancelada'): ?>
                                                    <a href="index.php?url=recepcionista/cancelar_cita&id=<?= urlencode($cita['id']) ?>" 
                                                       class="btn btn-sm btn-danger"
                                                       onclick="return confirm('¿Está seguro de cancelar esta cita?');">
                                                        Cancelar
                                                    </a>
                                                <?php endif; ?>
                                                <a href="index.php?url=recepcionista/editar_cita&id=<?= urlencode($cita['id']) ?>" 
                                                   class="btn btn-sm btn-primary">
                                                    Editar
                                                </a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="9" class="text-center">No hay citas registradas.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="index.php?url=recepcionista/dashboard" class="btn btn-secondary">Volver al Panel</a>
            </div>
        </div>
    </div>
</body>
</html>