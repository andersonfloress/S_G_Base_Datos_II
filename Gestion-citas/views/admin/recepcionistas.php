<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Recepcionistas</title>
</head>
<body>
    <h1>Recepcionistas</h1>

    <!-- Botones de navegación -->
    <div>
        <a href="index.php?url=admin/pacientes">Ver Pacientes</a>
        <a href="index.php?url=admin/medicos">Ver Médicos</a>
        <a href="index.php?url=admin/enfermeras">Ver Enfermeras</a>
        <a href="index.php?url=admin/recepcionistas">Ver Recepcionistas</a>
        <a href="index.php?url=admin/usuarios">Ver Todos los Usuarios</a>
        <a href="index.php?url=admin/dashboard">Volver al Dashboard</a>
    </div>

    <!-- Buscador -->
    <form method="GET" action="">
        <input type="hidden" name="url" value="admin/recepcionistas">
        <input type="text" name="busqueda" placeholder="Buscar por nombre, apellido o DNI">
        <button type="submit">Buscar</button>
    </form>

    <!-- Tabla de recepcionistas -->
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
            foreach ($recepcionistas as $recepcionista):
                if ($busqueda) {
                    if (
                        strpos(strtolower($recepcionista['nombre']), $busqueda) === false &&
                        strpos(strtolower($recepcionista['apellido']), $busqueda) === false &&
                        strpos(strtolower($recepcionista['dni']), $busqueda) === false
                    ) {
                        continue;
                    }
                }
                $encontro = true;
            ?>
                <tr>
                    <td><?= htmlspecialchars($recepcionista["id"]) ?></td>
                    <td><?= htmlspecialchars($recepcionista["nombre"]) ?></td>
                    <td><?= htmlspecialchars($recepcionista["apellido"]) ?></td>
                    <td><?= htmlspecialchars($recepcionista["dni"]) ?></td>
                    <td><?= htmlspecialchars($recepcionista["email"]) ?></td>
                    <td><?= htmlspecialchars($recepcionista["telefono"]) ?></td>
                    <td><?= htmlspecialchars($recepcionista["direccion"]) ?></td>
                    <td><?= htmlspecialchars($recepcionista["fecha_nacimiento"]) ?></td>
                    <td>
                        <a href="index.php?url=admin/editarUsuario/<?= $recepcionista['id'] ?>">Editar</a>
                        <a href="index.php?url=admin/eliminarUsuario/<?= $recepcionista['id'] ?>" onclick="return confirm('¿Eliminar este recepcionista?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$encontro): ?>
                <tr>
                    <td colspan="9">No se encontraron recepcionistas.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
