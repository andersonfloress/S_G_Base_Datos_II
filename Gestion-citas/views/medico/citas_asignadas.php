<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="assets/css/medico.css">
    <meta charset="UTF-8">
    <title>Citas Asignadas</title>
</head>
<body>
    <h2>Citas Asignadas de Hoy</h2>

    <div>
        
    </div>

    <table border="1" cellpadding="5">
        <tr>
            <th>N°</th>
            <th>Paciente</th>
            <th>Fecha</th>
            <th>Día</th>
            <th>Hora</th>
            <th>Motivo</th>
            <th>Acciones</th> <!-- Encabezado correcto -->
        </tr>
        <?php 
        $contador = 1;
        $hoy = date('Y-m-d');
        $encontro = false;
        foreach ($citas as $cita): 
            if ($cita['fecha'] !== $hoy) {
                continue; // Mostrar solo citas de hoy
            }
            $dias = ["Domingo","Lunes","Martes","Miércoles","Jueves","Viernes","Sabado"];
            $diaSemana = $dias[date('w', strtotime($cita['fecha']))];
            $encontro = true;
        ?>
            <tr>
                <td><?= $contador++ ?></td>
                <td><?= htmlspecialchars($cita['nombre_paciente']) ?></td>
                <td><?= htmlspecialchars($cita['fecha']) ?></td>
                <td><?= $diaSemana ?></td>
                <td><?= htmlspecialchars($cita['hora']) ?></td>
                <td><?= htmlspecialchars($cita['motivo']) ?></td>
                <td>
                    <a href="index.php?url=medico/ver_historial&id=<?= $cita['paciente_id'] ?>">Ver Historial</a>
                    |
                    <a href="index.php?url=medico/registrar_diagnostico&cita_id=<?= $cita['id'] ?>&paciente_id=<?= $cita['paciente_id'] ?>">Atender</a>
                </td>
            </tr>
        <?php endforeach; ?>
        <?php if (!$encontro): ?>
            <tr>
                <td colspan="7">No hay citas para hoy.</td>
            </tr>
        <?php endif; ?>
    </table>
</body>
</html>
