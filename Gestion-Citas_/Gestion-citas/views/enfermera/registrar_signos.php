<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="assets/css/enfermeria.css">
    <meta charset="UTF-8">
    <title>Registrar Signos Vitales</title>
</head>
<body>
    <h2>Registrar Signos Vitales</h2>

    <?php if (isset($exito)) echo "<p style='color: green;'>$exito</p>"; ?>
    <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>

    <form method="POST">
        <label>Paciente:</label>
        <?php if (isset($_GET['paciente_id']) && $paciente_seleccionado): ?>
            <!-- Si viene con paciente_id Y existe el paciente -->
            <input type="hidden" name="paciente_id" value="<?= $_GET['paciente_id'] ?>">
            <input type="text" value="<?= htmlspecialchars($paciente_seleccionado['nombre'] . ' ' . $paciente_seleccionado['apellido'] . ' - DNI: ' . $paciente_seleccionado['dni']) ?>" readonly>
        <?php else: ?>
            <!-- Si no viene con paciente_id, mostrar el select -->
            <select name="paciente_id" required>
                <option value="">Seleccione un paciente</option>
                <?php foreach ($pacientes as $paciente): ?>
                    <option value="<?= $paciente['id'] ?>">
                        <?= htmlspecialchars($paciente['nombre'] . ' ' . $paciente['apellido'] . ' - DNI: ' . $paciente['dni']) ?>
                    </option>
                <?php endforeach; ?>
            </select>
        <?php endif; ?>
        <br><br>

        <label>Fecha:</label>
        <input type="date" name="fecha" value="<?= date('Y-m-d') ?>" required><br><br>

        <label>Hora:</label>
        <input type="time" name="hora" value="<?= date('H:i') ?>" required><br><br>

        <label>Presión Arterial:</label>
        <input type="text" name="presion_arterial" placeholder="Ej: 120/80"><br><br>

        <label>Frecuencia Cardíaca (lpm):</label>
        <input type="number" name="frecuencia_cardiaca"><br><br>

        <label>Frecuencia Respiratoria (rpm):</label>
        <input type="number" name="frecuencia_respiratoria"><br><br>

        <label>Temperatura (°C):</label>
        <input type="number" step="0.1" name="temperatura"><br><br>

        <label>Saturación de Oxígeno (%):</label>
        <input type="number" name="saturacion_oxigeno"><br><br>

        <label>Observaciones:</label><br>
        <textarea name="observaciones" rows="4" cols="40"></textarea><br><br>

        <button type="submit">Registrar</button>
    </form>

    <br>
    <a href="index.php?url=enfermera/dashboard">Volver al Dashboard</a>
</body>
</html>
