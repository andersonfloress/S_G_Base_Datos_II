<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Usuario - Administración</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    function mostrarEspecialidad() {
        const rol = document.getElementById("rol_id").value;
        const espMedico = document.getElementById("especialidad_medico_group");
        const espExamen = document.getElementById("especialidad_examen_group");

        espMedico.style.display = "none";
        espExamen.style.display = "none";

        if (rol == "2") { // Médico
            espMedico.style.display = "block";
        } else if (rol == "6") { // Especialista de Exámenes
            espExamen.style.display = "block";
        }
    }
    </script>
</head>
<body>
    <div class="container-fluid">
        <div class="main-content">
            <h1>Crear Usuario</h1>
            
            <?php if (!empty($error)): ?>
                <div class="alert alert-danger" role="alert">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <div class="card">
                <div class="card-header">
                    <h3 class="text-white mb-0">Información del Usuario</h3>
                </div>
                <div class="card-body">
                    <form method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="nombre" class="form-label">Nombre:</label>
                                <input type="text" class="form-control" id="nombre" name="nombre" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="apellido" class="form-label">Apellido:</label>
                                <input type="text" class="form-control" id="apellido" name="apellido" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="dni" class="form-label">DNI:</label>
                                <input type="text" class="form-control" id="dni" name="dni" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email:</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Contraseña:</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="telefono" class="form-label">Teléfono:</label>
                                <input type="text" class="form-control" id="telefono" name="telefono">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="direccion" class="form-label">Dirección:</label>
                                <input type="text" class="form-control" id="direccion" name="direccion">
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento:</label>
                                <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="rol_id" class="form-label">Rol:</label>
                            <select class="form-select" name="rol_id" id="rol_id" onchange="mostrarEspecialidad()" required>
                                <option value="">Seleccione Rol</option>
                                <option value="2">Médico</option>
                                <option value="3">Enfermera</option>
                                <option value="4">Recepcionista</option>
                                <option value="6">Especialista de Exámenes</option>
                            </select>
                        </div>

                        <!-- Especialidades Médico -->
                        <div id="especialidad_medico_group" style="display:none;" class="mb-3">
                            <label for="especialidad_id" class="form-label">Especialidad (Médico):</label>
                            <select class="form-select" name="especialidad_id" id="especialidad_id">
                                <option value="">Seleccione Especialidad</option>
                                <?php foreach ($especialidades_medicas as $esp): ?>
                                    <option value="<?= $esp['id'] ?>">
                                        <?= htmlspecialchars($esp['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <!-- Especialidades Especialista Exámenes -->
                        <div id="especialidad_examen_group" style="display:none;" class="mb-3">
                            <label for="especialidad_examen_id" class="form-label">Especialidad (Especialista de Exámenes):</label>
                            <select class="form-select" name="especialidad_examen_id" id="especialidad_examen_id">
                                <option value="">Seleccione Especialidad</option>
                                <?php foreach ($especialidades_examenes as $esp): ?>
                                    <option value="<?= $esp['id'] ?>">
                                        <?= htmlspecialchars($esp['nombre']) ?>
                                    </option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                            <a href="index.php?url=admin/usuarios" class="btn btn-secondary">Cancelar</a>
                            <button type="submit" class="btn btn-primary">Guardar Usuario</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>