<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Clínico del Paciente</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <h2>Historial Clínico de <?= htmlspecialchars($paciente['nombre']) . ' ' . htmlspecialchars($paciente['apellido']) ?></h2>

    <table border="1">
        <tr>
            <th>Fecha</th>
            <th>Signos Vitales</th>
            <th>Observaciones</th>
            <th>Diagnóstico Médico</th>
        </tr>
        <?php foreach ($historial as $registro): ?>
            <tr>
                <td><?= htmlspecialchars($registro['fecha']) ?></td>
                <td>
                    Presión: <?= htmlspecialchars($registro['presion']) ?><br>
                    Temperatura: <?= htmlspecialchars($registro['temperatura']) ?><br>
                    Peso: <?= htmlspecialchars($registro['peso']) ?>
                </td>
                <td><?= nl2br(htmlspecialchars($registro['observaciones'])) ?></td>
                <td><?= nl2br(htmlspecialchars($registro['diagnostico'])) ?></td>
            </tr>
        <?php endforeach; ?>
    </table>

    <button onclick="location.href='index.php?url=enfermera/ver_citas'">Volver a Citas</button>
</body>
</html>
