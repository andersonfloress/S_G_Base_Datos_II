<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Clínico - Gestión de Citas</title>
     <link rel="stylesheet" href="assets/css/paciente.css">
</head>
<body>
    <div class="container">
        <h1>Historial Clínico</h1>
        <p>Revisa aquí tu historial clínico completo.</p>

        <table border="1" cellpadding="8" cellspacing="0">
            <thead>
                <tr>
                    <th>Fecha</th>
                    <th>Especialidad</th>
                    <th>Doctor</th>
                    <th>Diagnóstico</th>
                    <th>Tratamiento</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($historial)): ?>
                    <?php foreach ($historial as $registro): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($registro['fecha']); ?></td>
                            <td><?php echo htmlspecialchars($registro['especialidad']); ?></td>
                            <td><?php echo htmlspecialchars($registro['doctor']); ?></td>
                            <td><?php echo htmlspecialchars($registro['diagnostico']); ?></td>
                            <td><?php echo htmlspecialchars($registro['tratamiento']); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No tienes historial clínico registrado.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <br>
        <button onclick="location.href='index.php?url=paciente/dashboard'">Volver al Panel</button>
        <button onclick="location.href='index.php?url=paciente/descargarHistorial'">Descargar en PDF</button>
    </div>
</body>
</html>
