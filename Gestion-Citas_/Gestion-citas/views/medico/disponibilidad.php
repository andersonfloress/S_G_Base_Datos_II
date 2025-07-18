<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Disponibilidad de Horarios</title>
</head>
<body>
    <h2>Mi Disponibilidad de Horarios</h2>

    <!-- Mostrar mensajes de éxito o error -->
    <?php if (isset($exito)) echo "<p style='color:green;'>$exito</p>"; ?>
    <?php if (isset($error)) echo "<p style='color:red;'>$error</p>"; ?>

    <!-- Formulario para registrar disponibilidad -->
    <form method="POST" action="">
        <label>Día de la Semana:</label>
        <select name="dia_semana" required>
            <option value="">Seleccionar...</option>
            <option value="Lunes">Lunes</option>
            <option value="Martes">Martes</option>
            <option value="Miércoles">Miércoles</option>
            <option value="Jueves">Jueves</option>
            <option value="Viernes">Viernes</option>
            <option value="Sabado">Sábado</option>
            <option value="Domingo">Domingo</option>
        </select>

        <label>Turno:</label>
        <select name="turno" required>
            <option value="">Seleccionar...</option>
            <option value="Mañana">Mañana</option>
            <option value="Tarde">Tarde</option>
        </select>

        <button type="submit">Registrar Disponibilidad</button>
    </form>

    <h3>Disponibilidades Registradas</h3>
    <table border="1" cellpadding="5">
        <tr>
            <th>#</th>
            <th>Día</th>
            <th>Turno</th>
        </tr>
        <?php if (!empty($disponibilidades)): ?>
            <?php $n = 1; foreach ($disponibilidades as $disp): ?>
                <tr>
                    <td><?= $n++ ?></td>
                    <td><?= htmlspecialchars($disp['dia_semana']) ?></td>
                    <td><?= htmlspecialchars($disp['turno']) ?></td>
                </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr>
                <td colspan="3">No hay disponibilidades registradas.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
