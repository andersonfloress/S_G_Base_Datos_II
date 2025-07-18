<!-- Archivo: /views/recepcionista/ver_pacientes.php -->
<link rel="stylesheet" href="assets/css/recepcionista.css">
<h2>Lista de Pacientes Registrados</h2>

<table border="1" cellpadding="5">
    <tr>
        <th>N°</th>
        <th>Nombre</th>
        <th>Apellido</th>
        <th>DNI</th>
        <th>Teléfono</th>
        <th>Dirección</th>
        <th>Fecha de Nacimiento</th>
        <th>Email</th>
    </tr>

    <?php if (!empty($pacientes)): ?>
        <?php $n = 1; foreach ($pacientes as $paciente): ?>
            <tr>
                <td><?= $n++ ?></td>
                <td><?= htmlspecialchars($paciente['nombre']) ?></td>
                <td><?= htmlspecialchars($paciente['apellido']) ?></td>
                <td><?= htmlspecialchars($paciente['dni']) ?></td>
                <td><?= htmlspecialchars($paciente['telefono']) ?></td>
                <td><?= htmlspecialchars($paciente['direccion']) ?></td>
                <td><?= htmlspecialchars($paciente['fecha_nacimiento']) ?></td>
                <td><?= htmlspecialchars($paciente['email']) ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="8">No hay pacientes registrados.</td>
        </tr>
    <?php endif; ?>
</table>

<br>
<a href="index.php?url=recepcionista/dashboard">Volver al Panel</a>
