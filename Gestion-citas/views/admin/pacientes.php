<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pacientes</title>
</head>
<body>
    <h1>Pacientes</h1>

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
        <input type="hidden" name="url" value="admin/pacientes">
        <input type="text" name="busqueda" placeholder="Buscar por nombre, apellido o DNI">
        <button type="submit">Buscar</button>
    </form>

    <!-- Tabla de pacientes -->
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
            foreach ($pacientes as $paciente):
                if ($busqueda) {
                    if (
                        strpos(strtolower($paciente['nombre']), $busqueda) === false &&
                        strpos(strtolower($paciente['apellido']), $busqueda) === false &&
                        strpos(strtolower($paciente['dni']), $busqueda) === false
                    ) {
                        continue;
                    }
                }
                $encontro = true;
            ?>
                <tr>
                    <td><?= htmlspecialchars($paciente["id"]) ?></td>
                    <td><?= htmlspecialchars($paciente["nombre"]) ?></td>
                    <td><?= htmlspecialchars($paciente["apellido"]) ?></td>
                    <td><?= htmlspecialchars($paciente["dni"]) ?></td>
                    <td><?= htmlspecialchars($paciente["email"]) ?></td>
                    <td><?= htmlspecialchars($paciente["telefono"]) ?></td>
                    <td><?= htmlspecialchars($paciente["direccion"]) ?></td>
                    <td><?= htmlspecialchars($paciente["fecha_nacimiento"]) ?></td>
                    <td>
                        <a href="index.php?url=admin/editarUsuario/<?= $paciente['id'] ?>">Editar</a>
                        <a href="index.php?url=admin/eliminarUsuario/<?= $paciente['id'] ?>" onclick="return confirm('¿Eliminar este paciente?')">Eliminar</a>
                    </td>
                </tr>
            <?php endforeach; ?>
            <?php if (!$encontro): ?>
                <tr>
                    <td colspan="9">No se encontraron pacientes.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
