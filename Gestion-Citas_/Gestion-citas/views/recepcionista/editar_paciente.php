<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Cita</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h1>Editar Cita</h1>

    <a href="index.php?url=recepcionista/citas">⬅️ Volver a Citas</a>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if (isset($mensaje)): ?>
        <p style="color:green;"><?php echo htmlspecialchars($mensaje); ?></p>
    <?php endif; ?>

    <form action="index.php?url=recepcionista/editarCita&id=<?php echo $cita['id']; ?>" method="POST">
        <label for="fecha">Fecha:</label><br>
        <input type="date" name="fecha" id="fecha" value="<?php echo $cita['fecha']; ?>" required><br><br>

        <label for="hora">Hora:</label><br>
        <input type="time" name="hora" id="hora" value="<?php echo $cita['hora']; ?>" required><br><br>

        <label for="estado">Estado:</label><br>
        <select name="estado" id="estado" required>
            <option value="Pendiente" <?php if ($cita['estado'] == 'Pendiente') echo 'selected'; ?>>Pendiente</option>
            <option value="Atendida" <?php if ($cita['estado'] == 'Atendida') echo 'selected'; ?>>Atendida</option>
            <option value="Cancelada" <?php if ($cita['estado'] == 'Cancelada') echo 'selected'; ?>>Cancelada</option>
        </select><br><br>

        <button type="submit">Actualizar Cita</button>
    </form>
</body>
</html>
