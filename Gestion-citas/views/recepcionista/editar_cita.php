<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Cita - Gestión de Citas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="main-content">
            <h1>Editar Cita</h1>
            
            <div class="mb-3">
                <a href="index.php?url=recepcionista/citas" class="btn btn-secondary">
                    ⬅️ Volver a Citas
                </a>
            </div>

            <?php if (isset($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo htmlspecialchars($error); ?>
                </div>
            <?php endif; ?>

            <?php if (isset($mensaje)): ?>
                <div class="alert alert-success" role="alert">
                    <?php echo htmlspecialchars($mensaje); ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3 class="text-white mb-0">Modificar Información de la Cita</h3>
                </div>
                <div class="card-body">
                    <form action="index.php?url=recepcionista/editarCita&id=<?php echo $cita['id']; ?>" method="POST">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fecha" class="form-label">Fecha:</label>
                                <input type="date" class="form-control" name="fecha" id="fecha" value="<?php echo $cita['fecha']; ?>" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="hora" class="form-label">Hora:</label>
                                <input type="time" class="form-control" name="hora" id="hora" value="<?php echo $cita['hora']; ?>" required>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="estado" class="form-label">Estado:</label>
                            <select class="form-select" name="estado" id="estado" required>
                                <option value="Pendiente" <?php if ($cita['estado'] == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
                                <option value="Atendida" <?php if ($cita['estado'] == 'Atendida') echo 'selected'; ?>>Atendida</option>
                                <option value="Cancelada" <?php if ($cita['estado'] == 'Cancelada') echo 'selected'; ?>>Cancelada</option>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php?url=recepcionista/citas" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Actualizar Cita</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>