<!-- Archivo: /Gestion-Citas/views/recepcionista/registrar_cita_paciente.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Cita de Paciente</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h2>Registrar Cita para Paciente</h2>

    <?php if (isset($error)): ?>
        <p style="color: red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (isset($exito)): ?>
        <p style="color: green;"><?= htmlspecialchars($exito) ?></p>
    <?php endif; ?>

    <?php if ($paciente): ?>
        <h3>Paciente Seleccionado</h3>
        <p><strong>Nombre:</strong> <?= htmlspecialchars($paciente['nombre']) ?> <?= htmlspecialchars($paciente['apellido']) ?></p>
        <p><strong>DNI:</strong> <?= htmlspecialchars($paciente['dni']) ?></p>
        <p><strong>Teléfono:</strong> <?= htmlspecialchars($paciente['telefono']) ?></p>
        <p><strong>Dirección:</strong> <?= htmlspecialchars($paciente['direccion']) ?></p>

        <h3>Registrar Cita</h3>
        <form method="POST" action="index.php?url=recepcionista/registrar_cita_paciente&paciente_id=<?= urlencode($paciente['paciente_id']) ?>">
            <label for="tipo_cita">Tipo de Atención:</label><br>
            <select name="tipo_cita" id="tipo_cita" required>
                <option value="">Seleccione</option>
                <option value="consulta">Consulta Médica</option>
                <option value="examen">Examen</option>
            </select><br><br>

            <label for="fecha">Fecha:</label><br>
            <input type="date" name="fecha" id="fecha" required><br><br>

            <label for="hora">Hora:</label><br>
            <input type="time" name="hora" id="hora" required><br><br>

            <label for="medico_id">Seleccionar Médico Disponible:</label><br>
            <select name="medico_id" id="medico_id" required>
                <option value="">Seleccione un médico</option>
                <?php if (!empty($medicos_disponibles)): ?>
                    <?php foreach ($medicos_disponibles as $medico): ?>
                        <option value="<?= htmlspecialchars($medico['id']) ?>">
                            <?= htmlspecialchars($medico['nombre'] . ' ' . $medico['apellido'] . ' - ' . $medico['especialidad']) ?>
                        </option>
                    <?php endforeach; ?>
                <?php else: ?>
                    <option value="">No hay médicos disponibles para la fecha y hora seleccionadas</option>
                <?php endif; ?>
            </select><br><br>

            <label for="motivo_cita">Motivo de la cita:</label><br>
            <textarea name="motivo_cita" id="motivo_cita" rows="3" required></textarea><br><br>

            <button type="submit" name="reservar_cita">Reservar Cita</button>
        </form>

    <?php else: ?>
        <p>No hay paciente seleccionado.</p>
        <a href="index.php?url=recepcionista/registrar_cita">
            <button>Buscar Paciente</button>
        </a>
    <?php endif; ?>

    <br>
    <a href="index.php?url=recepcionista/dashboard">Volver al Dashboard</a>
</body>
</html>
