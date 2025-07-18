<?php

// Archivo: /views/enfermera/citas_del_dia.php

// Función para calcular edad
function calcularEdad($fechaNacimiento) {
    $nacimiento = new DateTime($fechaNacimiento);
    $hoy = new DateTime();
    $edad = $hoy->diff($nacimiento);
    return $edad->y;
}
?>
<link rel="stylesheet" href="assets/css/enfermeria.css">
<h2>Citas del Día</h2>

<table border="1">
    <tr>
        <th>N°</th>
        <th>Nombre</th>
        <th>Apellidos</th>
        <th>DNI</th>
        <th>Fecha Nacimiento</th>
        <th>Edad</th>
        <th>Motivo</th>
        <th>Fecha</th>
        <th>Hora</th>
        <th>Acciones</th>
    </tr>

    <?php if (count($citas) > 0): ?>
        <?php 
        $n = 1;
        foreach ($citas as $cita):
            // Comprobar si ya se registraron signos
           $ya_registrado = $this->enfermeraModelo->verificarSignosRegistrados($cita['id'], $cita['id']);
        ?>
            <tr>
                <td><?= $n++ ?></td>
                <td><?= htmlspecialchars($cita['nombre']) ?></td>
                <td><?= htmlspecialchars($cita['apellido']) ?></td>
                <td><?= htmlspecialchars($cita['dni']) ?></td>
                <td><?= htmlspecialchars($cita['fecha_nacimiento']) ?></td>
                <td><?= calcularEdad($cita['fecha_nacimiento']) ?> años</td>
                <td><?= htmlspecialchars($cita['motivo_cita']) ?></td>
                <td><?= htmlspecialchars($cita['fecha']) ?></td>
                <td><?= htmlspecialchars($cita['hora']) ?></td>
                <td>
                    <?php if (!$ya_registrado): ?>
                        <a href="index.php?url=enfermera/registrar_signos&paciente_id=<?= $cita['id'] ?>&cita_id=<?= $cita['id'] ?>">
                            Registrar signos
                        </a>
                    <?php else: ?>
                        Registrado
                    <?php endif; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="10">No hay citas registradas para hoy.</td>
        </tr>
    <?php endif; ?>
</table>
<!-- Botón volver al dashboard -->
<br>
<a href="index.php?url=enfermera/dashboard">
    <button>Volver al Dashboard</button>
</a>