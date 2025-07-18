<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Examen</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h2>Editar Examen</h2>

    <?php if ($examen): ?>
        <form action="index.php?url=examen/actualizar" method="POST">
            <input type="hidden" name="id" value="<?php echo $examen['id']; ?>">

            <label>Fecha:</label>
            <input type="date" name="fecha" value="<?php echo $examen['fecha']; ?>" required><br>

            <label>Hora:</label>
            <input type="time" name="hora" value="<?php echo $examen['hora']; ?>" required><br>

            <label>Motivo:</label>
            <textarea name="motivo"><?php echo $examen['motivo'] ?? ''; ?></textarea><br>

            <button type="submit">Actualizar</button>
        </form>
    <?php else: ?>
        <p>Examen no encontrado.</p>
    <?php endif; ?>

    <br>
    <a href="index.php?url=cita/misCitas">Volver a Mis Citas y Exámenes</a>
</body>
</html>
