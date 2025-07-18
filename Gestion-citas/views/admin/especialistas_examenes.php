<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Especialistas de Exámenes</title>
</head>
<body>
    <h1>Especialistas de Exámenes</h1>

    <!-- Botones de navegación -->
    <div>
        <a href="index.php?url=admin/pacientes">Ver Pacientes</a>
        <a href="index.php?url=admin/medicos">Ver Médicos</a>
        <a href="index.php?url=admin/enfermeras">Ver Enfermeras</a>
        <a href="index.php?url=admin/recepcionistas">Ver Recepcionistas</a>
        <a href="index.php?url=admin/especialistas_examenes">Ver Especialistas de Exámenes</a>
        <a href="index.php?url=admin/usuarios">Ver Todos los Usuarios</a>
        <a href="index.php?url=admin/dashboard">Volver al Dashboard</a>
    </div>

    <!-- Buscador -->
    <form method="GET" action="">
        <input type="hidden" name="url" value="admin/especialistasExamenes">
        <input type="text" name="busqueda" placeholder="Buscar por nombre, apellido o DNI">
        <button type="submit">Buscar</button>
    </form>

    <!-- Tabla de especialistas de exámenes -->
    <table border="1" cellpadding="5">
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
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $busqueda = isset($_GET['busqueda']) ? strtolower(trim($_GET['busqueda'])) : '';
            $encontro = false;
            foreach ($especialistas as $especialista):
                if ($busqueda) {
                    if (
                        strpos(strtolower($especialista['nombre']), $busqueda) === false &&
                        strpos(strtolower($especialista['apellido']), $busqueda) === false &&
                        strpos(strtolower($especialista['dni']), $busqueda) === false
                    ) {
                        continue;
                    }
                }
                $encontro = true;
            ?>
                <tr>
                    <td><?= htmlspecialchars($especialista["id"]) ?></td>
                    <td><?= htmlspecialchars($especialista["nombre"]) ?></td>
                    <td><?= htmlspecialchars($especialista["apellido"]) ?></td>
                    <td><?= htmlspecialchars($especialista["dni"]) ?></td>
                    <td><?= htmlspecialchars($especialista["email"]) ?></td>
                    <td><?= htmlspecialchars($especialista["telefono"]) ?></td>
                    <td><?= htmlspecialchars($especialista["direccion"]) ?></td>
                    <td><?= htmlspecialchars($especialista["fecha_nacimiento"]) ?></td>
                    <td>
                        <a href="index.php?url=admin/editarUsuario/<?= $especialista['id'] ?>">Editar</a>
                        <a href="index.php?url=admin/eliminarUsuario/<?= $especialista['id'] ?>" onclick="return confirm('¿Eliminar este especialista?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$encontro): ?>
                <tr>
                    <td colspan="9">No se encontraron especialistas de exámenes.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
