<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="assets/css/medico.css">
    <meta charset="UTF-8">
    <title>Historial de Pacientes</title>
</head>
<body>
    <h2>Historial de Pacientes Atendidos</h2>

    <!-- Buscador -->
    <form method="GET" action="">
        <input type="hidden" name="url" value="medico/historiales">
        <input type="text" name="nombre" placeholder="Buscar por nombre">
        <input type="text" name="apellido" placeholder="Buscar por apellido">
        <input type="date" name="fecha">
        <button type="submit">Buscar</button>
    </form>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>#</th>
                <th>Nombre</th>
                <th>Apellido</th>
                <th>DNI</th>
                <th>Edad</th>
                <th>Fecha de la cita</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($historiales)): ?>
                <?php $n = 1; foreach ($historiales as $p): 
                    $edad = (new DateTime($p['fecha_nacimiento']))->diff(new DateTime())->y;
                ?>
                    <tr>
                        <td><?= $n++ ?></td>
                        <td><?= htmlspecialchars($p['nombre']) ?></td>
                        <td><?= htmlspecialchars($p['apellido']) ?></td>
                        <td><?= htmlspecialchars($p['dni']) ?></td>
                        <td><?= $edad ?> años</td>
                        <td><?= htmlspecialchars($p['fecha']) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr><td colspan="6">No hay registros de pacientes atendidos.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
