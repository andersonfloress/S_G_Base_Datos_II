<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Médicos</title>
</head>
<body>
    <h1>Médicos</h1>

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
        <input type="hidden" name="url" value="admin/medicos">
        <input type="text" name="busqueda" placeholder="Buscar por nombre, apellido o DNI">
        <button type="submit">Buscar</button>
    </form>

    <!-- Tabla de médicos -->
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
            foreach ($medicos as $medico):
                if ($busqueda) {
                    if (
                        strpos(strtolower($medico['nombre']), $busqueda) === false &&
                        strpos(strtolower($medico['apellido']), $busqueda) === false &&
                        strpos(strtolower($medico['dni']), $busqueda) === false
                    ) {
                        continue;
                    }
                }
                $encontro = true;
            ?>
                <tr>
                    <td><?= htmlspecialchars($medico["id"]) ?></td>
                    <td><?= htmlspecialchars($medico["nombre"]) ?></td>
                    <td><?= htmlspecialchars($medico["apellido"]) ?></td>
                    <td><?= htmlspecialchars($medico["dni"]) ?></td>
                    <td><?= htmlspecialchars($medico["email"]) ?></td>
                    <td><?= htmlspecialchars($medico["telefono"]) ?></td>
                    <td><?= htmlspecialchars($medico["direccion"]) ?></td>
                    <td><?= htmlspecialchars($medico["fecha_nacimiento"]) ?></td>
                    <td>
                        <a href="index.php?url=admin/editarUsuario/<?= $medico['id'] ?>">Editar</a>
                        <a href="index.php?url=admin/eliminarUsuario/<?= $medico['id'] ?>" onclick="return confirm('¿Eliminar este médico?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$encontro): ?>
                <tr>
                    <td colspan="9">No se encontraron médicos.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
