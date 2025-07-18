<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios - Administración</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="main-content">
            <h1>Gestión de Usuarios</h1>
            
            <!-- Navegación -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="btn-group" role="group">
                                <a href="index.php?url=admin/pacientes" class="btn btn-outline-primary">Pacientes</a>
                                <a href="index.php?url=admin/medicos" class="btn btn-outline-primary">Médicos</a>
                                <a href="index.php?url=admin/enfermeras" class="btn btn-outline-primary">Enfermeras</a>
                                <a href="index.php?url=admin/recepcionistas" class="btn btn-outline-primary">Recepcionistas</a>
                                <a href="index.php?url=admin/usuarios" class="btn btn-primary">Todos</a>
                                <a href="index.php?url=admin/especialistas_examenes" class="btn btn-outline-primary">Especialistas</a>
                            </div>
                        </div>
                        <div class="col-md-6 text-end">
                            <a href="index.php?url=admin/dashboard" class="btn btn-secondary">Volver al Dashboard</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Buscador -->
            <div class="card filter-container">
                <h3>Buscar Usuario</h3>
                <form method="GET" class="row g-3">
                    <input type="hidden" name="url" value="admin/usuarios">
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="busqueda" placeholder="Buscar por nombre, apellido o DNI" value="<?= isset($_GET['busqueda']) ? htmlspecialchars($_GET['busqueda']) : '' ?>">
                    </div>
                    <div class="col-md-4">
                        <button type="submit" class="btn btn-primary w-100">Buscar</button>
                    </div>
                </form>
            </div>

            <!-- Tabla de usuarios -->
            <div class="card">
                <div class="card-header">
                    <h3 class="text-white mb-0">Lista de Usuarios</h3>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>DNI</th>
                                    <th>Email</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Fecha Nacimiento</th>
                                    <th>Rol</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($usuarios)): ?>
                                    <?php
                                    $busqueda = isset($_GET['busqueda']) ? strtolower(trim($_GET['busqueda'])) : '';
                                    $encontro = false;
                                    foreach ($usuarios as $usuario):
                                        if ($busqueda) {
                                            if (
                                                strpos(strtolower($usuario['nombre']), $busqueda) === false &&
                                                strpos(strtolower($usuario['apellido']), $busqueda) === false &&
                                                strpos(strtolower($usuario['dni']), $busqueda) === false
                                            ) {
                                                continue;
                                            }
                                        }
                                        $encontro = true;
                                    ?>
                                        <tr>
                                            <td><?= htmlspecialchars($usuario['id']) ?></td>
                                            <td><?= htmlspecialchars($usuario['nombre']) ?></td>
                                            <td><?= htmlspecialchars($usuario['apellido']) ?></td>
                                            <td><?= htmlspecialchars($usuario['dni']) ?></td>
                                            <td><?= htmlspecialchars($usuario['email']) ?></td>
                                            <td><?= htmlspecialchars($usuario['telefono']) ?></td>
                                            <td><?= htmlspecialchars($usuario['direccion']) ?></td>
                                            <td><?= htmlspecialchars($usuario['fecha_nacimiento']) ?></td>
                                            <td>
                                                <?php
                                                $rol_names = [
                                                    1 => 'Admin',
                                                    2 => 'Médico',
                                                    3 => 'Enfermera',
                                                    4 => 'Recepcionista',
                                                    5 => 'Paciente',
                                                    6 => 'Especialista'
                                                ];
                                                echo '<span class="badge bg-primary">' . ($rol_names[$usuario['rol_id']] ?? 'Desconocido') . '</span>';
                                                ?>
                                            </td>
                                            <td>
                                                <a href="index.php?url=admin/editarUsuario&id=<?= $usuario['id'] ?>" class="btn btn-sm btn-warning">Editar</a>
                                                <a href="index.php?url=admin/eliminarUsuario&id=<?= $usuario['id'] ?>" class="btn btn-sm btn-danger" onclick="return confirm('¿Eliminar usuario?')">Eliminar</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                    <?php if (!$encontro): ?>
                                        <tr>
                                            <td colspan="10" class="text-center">No se encontraron usuarios con esos datos.</td>
                                        </tr>
                                    <?php endif; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="10" class="text-center">No hay usuarios registrados.</td>
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