<!-- Archivo: /views/enfermera/seleccionar_turno.php -->

<h2>Seleccionar Disponibilidad de Turno</h2>

<?php if (isset($error)): ?>
    <p style="color:red;"><?= htmlspecialchars($error) ?></p>
<?php endif; ?>

<?php if (isset($exito)): ?>
    <p style="color:green;"><?= htmlspecialchars($exito) ?></p>
<?php endif; ?>

<form method="POST">
    <label for="dia_semana">Día de la Semana:</label>
    <select name="dia_semana" id="dia_semana" required>
        <option value="">--Seleccionar--</option>
        <option value="Lunes">Lunes</option>
        <option value="Martes">Martes</option>
        <option value="Miércoles">Miércoles</option>
        <option value="Jueves">Jueves</option>
        <option value="Viernes">Viernes</option>
        <option value="Sábado">Sábado</option>
        <option value="Domingo">Domingo</option>
    </select>

    <label for="turno">Turno:</label>
    <select name="turno" id="turno" required>
        <option value="">--Seleccionar--</option>
        <option value="Mañana">Mañana</option>
        <option value="Tarde">Tarde</option>
    </select>

    <button type="submit">Registrar Disponibilidad</button>
</form>

<h3>Disponibilidad Registrada</h3>

<?php if (!empty($disponibilidad)): ?>
    <table border="1">
        <tr>
            <th>N°</th>
            <th>Día de la Semana</th>
            <th>Turno</th>
            <th>Registrado</th>
        </tr>
        <?php $n = 1; foreach ($disponibilidad as $d): ?>
            <tr>
                <td><?= $n++ ?></td>
                <td><?= htmlspecialchars($d['dia_semana']) ?></td>
                <td><?= htmlspecialchars($d['turno']) ?></td>
                <td><?= htmlspecialchars($d['created_at']) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>
<?php else: ?>
    <p>No hay disponibilidad registrada.</p>
<?php endif; ?>
</table>

<!-- Botón volver al dashboard -->
<br>
<a href="index.php?url=enfermera/dashboard">
    <button>Volver al Dashboard</button>
</a>
