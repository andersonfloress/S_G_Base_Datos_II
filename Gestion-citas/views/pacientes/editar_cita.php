<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cita</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h2>Editar Cita</h2>

    <?php if ($cita): ?>
        <form method="POST" action="">
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="fecha" value="<?php echo $cita['fecha']; ?>" required><br><br>

            <label for="hora">Hora:</label>
            <input type="time" id="hora" name="hora" value="<?php echo $cita['hora']; ?>" required><br><br>

            <label for="motivo_cita">Motivo de la cita:</label>
            <input type="text" id="motivo_cita" name="motivo_cita" value="<?php echo $cita['motivo_cita']; ?>" required><br><br>

            <button type="submit">Guardar Cambios</button>
            <a href="index.php?url=cita/misCitas">Cancelar</a>
        </form>
    <?php else: ?>
        <p>Cita no encontrada.</p>
    <?php endif; ?>
</body>
</html>
