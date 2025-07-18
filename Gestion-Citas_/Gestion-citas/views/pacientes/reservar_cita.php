<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reservar Cita o Examen - Gestión de Citas</title>
    <link rel="stylesheet" href="assets/css/paciente.css">
    <script>
        function mostrarCamposDependientes() {
            const tipoAtencion = document.getElementById('tipo_atencion').value;
            document.getElementById('cita_campos').style.display = (tipoAtencion === 'cita_medica') ? 'block' : 'none';
            document.getElementById('examen_campos').style.display = (tipoAtencion === 'examen_medico') ? 'block' : 'none';
            
            // Limpiar campos
            document.getElementById('medico_id').innerHTML = '<option value="">Seleccione médico</option>';
            document.getElementById('especialista_examen_id').innerHTML = '<option value="">Seleccione especialista de examen</option>';
            document.getElementById('tipo_examen').innerHTML = '<option value="">Seleccione tipo de examen</option>';
        }

        function validarHora() {
            const horaInput = document.getElementById('hora');
            const hora = horaInput.value;
            if (!hora) return;

            const [hh, mm] = hora.split(":").map(Number);
            const minutosTotales = hh * 60 + mm;

            if (minutosTotales >= 360 && minutosTotales <= 1080) { // 06:00 a 18:00
                const tipoAtencion = document.getElementById('tipo_atencion').value;
                if (tipoAtencion === 'cita_medica') {
                    cargarMedicos();
                } else if (tipoAtencion === 'examen_medico') {
                    cargarEspecialistasExamen();
                }
                return true;
            } else {
                alert("La hora debe estar entre 06:00 y 18:00.");
                horaInput.value = "";
                document.getElementById('medico_id').innerHTML = '<option value="">Seleccione médico</option>';
                document.getElementById('especialista_examen_id').innerHTML = '<option value="">Seleccione especialista de examen</option>';
                return false;
            }
        }

        function cargarMedicos() {
            const especialidadId = document.getElementById('especialidad_id').value;
            const hora = document.getElementById('hora').value;
            const tipoAtencion = document.getElementById('tipo_atencion').value;

            if (tipoAtencion !== 'cita_medica' || !especialidadId || !hora) {
                return;
            }

            const selectMedico = document.getElementById('medico_id');
            selectMedico.innerHTML = '<option value="">Cargando médicos...</option>';

            fetch('index.php?url=cita/obtenerMedicosDisponibles', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `especialidad_id=${especialidadId}&hora=${hora}`
            })
            .then(response => response.json())
            .then(data => {
                selectMedico.innerHTML = '<option value="">Seleccione médico</option>';

                if (data.error) {
                    alert('Error: ' + data.error);
                    return;
                }

                if (data.length === 0) {
                    selectMedico.innerHTML = '<option value="">No hay médicos disponibles</option>';
                    return;
                }

                data.forEach(medico => {
                    const option = document.createElement('option');
                    option.value = medico.id;
                    option.textContent = `${medico.nombre} ${medico.apellido}`;
                    selectMedico.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                selectMedico.innerHTML = '<option value="">Error al cargar médicos</option>';
            });
        }

        function cargarTiposExamen() {
            const especialidadExamenId = document.getElementById('especialidad_examen_id').value;
            
            if (!especialidadExamenId) {
                document.getElementById('tipo_examen').innerHTML = '<option value="">Seleccione tipo de examen</option>';
                return;
            }

            const selectTipoExamen = document.getElementById('tipo_examen');
            selectTipoExamen.innerHTML = '<option value="">Cargando tipos de examen...</option>';

            fetch('index.php?url=cita/obtenerTiposExamen', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `especialidad_examen_id=${especialidadExamenId}`
            })
            .then(response => response.json())
            .then(data => {
                selectTipoExamen.innerHTML = '<option value="">Seleccione tipo de examen</option>';

                if (data.error) {
                    alert('Error: ' + data.error);
                    return;
                }

                if (data.length === 0) {
                    selectTipoExamen.innerHTML = '<option value="">No hay tipos de examen disponibles</option>';
                    return;
                }

                data.forEach(tipo => {
                    const option = document.createElement('option');
                    option.value = tipo.id;
                    option.textContent = tipo.nombre;
                    selectTipoExamen.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                selectTipoExamen.innerHTML = '<option value="">Error al cargar tipos de examen</option>';
            });
        }

        function cargarEspecialistasExamen() {
            const hora = document.getElementById('hora').value;
            const tipoAtencion = document.getElementById('tipo_atencion').value;
            const tipoExamen = document.getElementById('tipo_examen').value;
            const especialidadExamenId = document.getElementById('especialidad_examen_id').value;

            if (tipoAtencion !== 'examen_medico' || !hora || !especialidadExamenId) {
                return;
            }

            const selectEspecialista = document.getElementById('especialista_examen_id_disponible');
            selectEspecialista.innerHTML = '<option value="">Cargando especialistas...</option>';

            let body = `hora=${hora}&especialidad_examen_id=${especialidadExamenId}`;
            if (tipoExamen) {
                body += `&tipo_examen=${tipoExamen}`;
            }

            fetch('index.php?url=cita/obtenerEspecialistasExamenDisponibles', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: body
            })
            .then(response => response.json())
            .then(data => {
                selectEspecialista.innerHTML = '<option value="">Seleccione especialista de examen</option>';

                if (data.error) {
                    alert('Error: ' + data.error);
                    return;
                }

                if (data.length === 0) {
                    selectEspecialista.innerHTML = '<option value="">No hay especialistas disponibles</option>';
                    return;
                }

                data.forEach(especialista => {
                    const option = document.createElement('option');
                    option.value = especialista.id;
                    option.textContent = `${especialista.nombre} ${especialista.apellido}`;
                    selectEspecialista.appendChild(option);
                });
            })
            .catch(error => {
                console.error('Error:', error);
                selectEspecialista.innerHTML = '<option value="">Error al cargar especialistas</option>';
            });
        }

        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('especialidad_id').addEventListener('change', cargarMedicos);
            document.getElementById('hora').addEventListener('change', validarHora);
            document.getElementById('especialidad_examen_id').addEventListener('change', function() {
                cargarTiposExamen();
                cargarEspecialistasExamen();
            });
            document.getElementById('tipo_examen').addEventListener('change', cargarEspecialistasExamen);
        });
    </script>
</head>
<body>
    <h2>Reservar Cita o Examen</h2>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>

    <?php if (isset($exito)): ?>
        <p style="color:green;"><?php echo htmlspecialchars($exito); ?></p>
    <?php endif; ?>

    <form action="index.php?url=cita/reservar" method="POST">
        <label for="tipo_atencion">Tipo de atención:</label><br>
        <select id="tipo_atencion" name="tipo_atencion" required onchange="mostrarCamposDependientes()">
            <option value="">Seleccione</option>
            <option value="cita_medica">Cita Médica</option>
            <option value="examen_medico">Examen Médico</option>
        </select><br><br>

        <label for="fecha">Fecha:</label><br>
        <input type="date" id="fecha" name="fecha" required><br><br>

        <label for="hora">Hora:</label><br>
        <input type="time" id="hora" name="hora" required onchange="validarHora()"><br><br>

        <div id="cita_campos" style="display:none;">
            <label for="especialidad_id">Especialidad:</label><br>
            <select id="especialidad_id" name="especialidad_id" onchange="cargarMedicos()">
                <option value="">Seleccione especialidad</option>
                <?php foreach ($especialidades as $esp): ?>
                    <option value="<?php echo $esp['id']; ?>"><?php echo htmlspecialchars($esp['nombre']); ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="medico_id">Médico:</label><br>
            <select id="medico_id" name="medico_id">
                <option value="">Seleccione médico</option>
            </select><br><br>
        </div>

        <div id="examen_campos" style="display:none;">
            <label for="especialidad_examen_id">Especialidad de Examen:</label><br>
            <select id="especialidad_examen_id" name="especialidad_examen_id" onchange="cargarTiposExamen(); cargarEspecialistasExamen();">
                <option value="">Seleccione especialidad de examen</option>
                <?php foreach ($especialidades_examenes as $esp_exam): ?>
                    <option value="<?php echo $esp_exam['id']; ?>"><?php echo htmlspecialchars($esp_exam['nombre']); ?></option>
                <?php endforeach; ?>
            </select><br><br>

            <label for="tipo_examen">Tipo de Examen:</label><br>
            <select id="tipo_examen" name="tipo_examen" onchange="cargarEspecialistasExamen()">
                <option value="">Seleccione tipo de examen</option>
            </select><br><br>

            <label for="especialista_examen_id_disponible">Especialista Examen Disponible:</label><br>
            <select id="especialista_examen_id_disponible" name="especialista_examen_id">
                <option value="">Seleccione especialista de examen</option>
            </select><br><br>
        </div>

        <label for="motivo">Motivo:</label><br>
        <textarea id="motivo" name="motivo" rows="3" required></textarea><br><br>

        <button type="submit">Reservar</button>
    </form>

    <br>
    <a href="index.php?url=paciente/dashboard"><button>Regresar al Panel</button></a>
</body>
</html>