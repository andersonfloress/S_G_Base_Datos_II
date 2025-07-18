<!DOCTYPE html>
<html lang="es">
<head>
    <link rel="stylesheet" href="assets/css/espe_examenes.css">
   <meta charset="UTF-8">
   <title>Próximas Citas de Exámenes</title>
</head>
<body>
   <h2>Próximas Citas de Exámenes</h2>

   <table border="1">
       <thead>
           <tr>
               <th>N°</th>
               <th>Nombres</th>
               <th>Apellidos</th>
               <th>Fecha</th>
               <th>Hora</th>
               <th>Motivo</th>
               <th>Resultados a</th>
               <th>Acciones</th>
           </tr>
       </thead>
       <tbody>
           <?php $contador = 1; ?>
           <?php foreach ($citas as $cita): ?>
               <tr>
                   <td><?php echo $contador++; ?></td>
                   <td><?php echo $cita['nombre_paciente']; ?></td>
                   <td><?php echo $cita['apellido_paciente']; ?></td>
                   <td><?php echo $cita['fecha']; ?></td>
                   <td><?php echo $cita['hora']; ?></td>
                   <td><?php echo $cita['motivo']; ?></td>
                   <td><?php echo $cita['tipo_resultado'] === 'pdf' ? 'Enviar' : 'Recoger'; ?></td>
                   <td>
                       <?php 
                       $fecha_hora_cita = $cita['fecha'] . ' ' . $cita['hora'];
                       $fecha_hora_actual = date('Y-m-d H:i:s');
                       
                       if ($fecha_hora_cita <= $fecha_hora_actual): ?>
                           <!-- Botón para marcar como "Examen Hecho" -->
                           <form action="index.php?url=especial_examenes/marcarExamenHecho" method="post" style="display:inline;">
                               <input type="hidden" name="cita_id" value="<?php echo $cita['id']; ?>">
                               <button type="submit">Examen Hecho</button>
                           </form>

                           <?php if ($cita['tipo_resultado'] === 'pdf'): ?>
                               <!-- Solo mostrar subida de PDF si es tipo PDF -->
                               <form action="index.php?url=especial_examenes/subirResultados" method="post" enctype="multipart/form-data" style="display:inline;">
                                   <input type="hidden" name="cita_id" value="<?php echo $cita['id']; ?>">
                                   <input type="file" name="archivo_pdf" accept=".pdf" required>
                                   <button type="submit">Subir PDF</button>
                               </form>
                           <?php else: ?>
                                <!-- Botón para avisar que está listo para recojo presencial -->
                                <form action="index.php?url=especial_examenes/notificarResultadoListo" method="post" style="display:inline;">
                                    <input type="hidden" name="cita_id" value="<?php echo $cita['id']; ?>">
                                    <button type="submit" style="background-color: green; color: white;">Avisar que está listo</button>
                                </form>
                            <?php endif; ?>
                       <?php else: ?>
                           <span style="color: gray;">Pendiente</span>
                       <?php endif; ?>
                   </td>
               </tr>
           <?php endforeach; ?>
       </tbody>
   </table>

   <button onclick="window.location.href='index.php?url=especial_examenes/dashboard'">Regresar</button>
</body>
</html>