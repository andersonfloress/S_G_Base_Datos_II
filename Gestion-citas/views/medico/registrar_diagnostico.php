<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Diagnóstico</title>
</head>
<body>
    <h2>Registrar Diagnóstico</h2>

    <!-- Mensaje de éxito -->
    <?php if (isset($exito)) : ?>
        <p style="color: green;"><?= htmlspecialchars($exito) ?></p>
    <?php endif; ?>

    <!-- Mostrar datos del paciente -->
    <h3>Datos del Paciente</h3>
    <p><strong>Nombre:</strong> <?= htmlspecialchars($paciente['nombre']) ?></p>
    <p><strong>Apellido:</strong> <?= htmlspecialchars($paciente['apellido']) ?></p>
    <p><strong>DNI:</strong> <?= htmlspecialchars($paciente['dni']) ?></p>
    <p><strong>Edad:</strong> <?= htmlspecialchars($paciente['edad']) ?> años</p>
    <p><strong>Fecha de la cita:</strong> <?= htmlspecialchars($cita['fecha']) ?></p>

    <!-- Formulario de diagnóstico -->
    <form method="POST" action="">
        <!-- Campos ocultos necesarios -->
        <input type="hidden" name="cita_id" value="<?= htmlspecialchars($cita['id']) ?>">
        <input type="hidden" name="paciente_id" value="<?= htmlspecialchars($paciente['id']) ?>">

        <label for="diagnostico">Diagnóstico:</label><br>
        <textarea name="diagnostico" id="diagnostico" rows="4" cols="50" required></textarea><br><br>

        <label for="tratamiento">Tratamiento:</label><br>
        <textarea name="tratamiento" id="tratamiento" rows="4" cols="50" required></textarea><br><br>

        <label for="observaciones">Observaciones:</label><br>
        <textarea name="observaciones" id="observaciones" rows="4" cols="50"></textarea><br><br>

        <button type="submit">Registrar Diagnóstico</button>
    </form>

    <br>
    <a href="index.php?url=medico/citas">Volver a Citas</a>
</body>
</html>
