<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Citas y Exámenes - Gestión de Citas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="main-content">
            <h1>Mis Citas y Exámenes</h1>
            
            <!-- Citas -->
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="text-white mb-0">Mis Citas</h2>
                </div>
                <div class="card-body">
                    <?php if (!empty($citas)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Profesional</th>
                                        <th>Especialidad</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($citas as $index => $cita): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo $cita['nombre_medico'] ?? '-'; ?></td>
                                            <td><?php echo $cita['nombre_especialidad'] ?? '-'; ?></td>
                                            <td><?php echo $cita['fecha']; ?></td>
                                            <td><?php echo $cita['hora']; ?></td>
                                            <td>
                                                <?php 
                                                    if ($cita['estado'] == 'reservada') {
                                                        echo '<span class="estado-pendiente">Pendiente</span>';
                                                    } elseif ($cita['estado'] == 'completada') {
                                                        echo '<span class="estado-completada">Completada</span>';
                                                    } elseif ($cita['estado'] == 'cancelada') {
                                                        echo '<span class="estado-cancelada">Cancelada</span>';
                                                    } else {
                                                        echo '<span class="badge bg-secondary">' . ucfirst($cita['estado']) . '</span>';
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($cita['estado'] != 'cancelada'): ?>
                                                    <a href="index.php?url=cita/editar&id=<?php echo $cita['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                                    <a href="index.php?url=cita/cancelar&id=<?php echo $cita['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de cancelar esta cita?')">Cancelar</a>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted">No tienes citas reservadas.</p>
                            <a href="index.php?url=cita/reservar" class="btn btn-success">Reservar Cita</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Exámenes -->
            <div class="card mb-4">
                <div class="card-header">
                    <h2 class="text-white mb-0">Mis Exámenes</h2>
                </div>
                <div class="card-body">
                    <?php if (!empty($examenes)): ?>
                        <div class="table-responsive">
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>N°</th>
                                        <th>Profesional</th>
                                        <th>Especialidad</th>
                                        <th>Tipo</th>
                                        <th>Fecha</th>
                                        <th>Hora</th>
                                        <th>Estado</th>
                                        <th>Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($examenes as $index => $examen): ?>
                                        <tr>
                                            <td><?php echo $index + 1; ?></td>
                                            <td><?php echo $examen['nombre_especialista'] ?? '-'; ?></td>
                                            <td><?php echo $examen['nombre_especialidad'] ?? '-'; ?></td>
                                            <td><?php echo $examen['nombre_examen'] ?? '-'; ?></td>
                                            <td><?php echo $examen['fecha']; ?></td>
                                            <td><?php echo $examen['hora']; ?></td>
                                            <td>
                                                <?php 
                                                    if ($examen['estado'] == 'reservada') {
                                                        echo '<span class="estado-pendiente">Pendiente</span>';
                                                    } elseif ($examen['estado'] == 'completada') {
                                                        echo '<span class="estado-completada">Completada</span>';
                                                    } elseif ($examen['estado'] == 'cancelada') {
                                                        echo '<span class="estado-cancelada">Cancelada</span>';
                                                    } else {
                                                        echo '<span class="badge bg-secondary">' . ucfirst($examen['estado']) . '</span>';
                                                    }
                                                ?>
                                            </td>
                                            <td>
                                                <?php if ($examen['estado'] == 'completada'): ?>
                                                    <?php if ($examen['tipo_resultado'] == 'pdf' && !empty($examen['nombre_archivo'])): ?>
                                                        <a href="index.php?url=paciente/descargarResultado&id=<?php echo $examen['id']; ?>" target="_blank" class="btn btn-sm btn-success">
                                                            Descargar Resultado
                                                        </a>
                                                    <?php elseif ($examen['tipo_resultado'] == 'presencial'): ?>
                                                        <span class="badge bg-success">Listo para recojo presencial</span>
                                                    <?php else: ?>
                                                        <span class="badge bg-warning">Resultado en proceso</span>
                                                    <?php endif; ?>
                                                <?php elseif ($examen['estado'] != 'cancelada'): ?>
                                                    <a href="index.php?url=examen/editar&id=<?php echo $examen['id']; ?>" class="btn btn-sm btn-primary">Editar</a>
                                                    <a href="index.php?url=examen/cancelar&id=<?php echo $examen['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Estás seguro de cancelar este examen?')">Cancelar</a>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted">No tienes exámenes reservados.</p>
                            <a href="index.php?url=cita/reservar" class="btn btn-success">Reservar Examen</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="index.php?url=paciente/dashboard" class="btn btn-secondary">Volver al Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>