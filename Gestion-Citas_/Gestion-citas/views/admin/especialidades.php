<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Especialidades - Administración</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="main-content">
            <h1>Gestión de Especialidades</h1>
            
            <div class="d-flex justify-content-between mb-4">
                <a href="index.php?url=admin/agregarEspecialidad" class="btn btn-success">Agregar Especialidad</a>
                <a href="index.php?url=admin/dashboard" class="btn btn-secondary">Volver al Dashboard</a>
            </div>
            
            <div class="card">
                <div class="card-header">
                    <h3 class="text-white mb-0">Lista de Especialidades</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($especialidades)): ?>
                                    <?php foreach ($especialidades as $especialidad): ?>
                                        <tr>
                                            <td><?= $especialidad["id"] ?></td>
                                            <td><?= htmlspecialchars($especialidad["nombre"]) ?></td>
                                            <td>
                                                <a href="index.php?url=admin/editarEspecialidad&id=<?= $especialidad["id"] ?>" class="btn btn-sm btn-warning">Editar</a>
                                                <a href="index.php?url=admin/eliminarEspecialidad&id=<?= $especialidad["id"] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar especialidad?')">Eliminar</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="3" class="text-center">No hay especialidades registradas</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>