<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Paciente - Gestión de Citas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-custom" style="max-width: 600px; width: 100%;">
            <div class="card-header text-center">
                <h1 class="text-white mb-0">Gestión de Citas</h1>
            </div>
            <div class="card-body">
                <h2 class="text-center mb-4">Registro de Paciente</h2>
                <p class="text-center text-muted mb-4">Complete el siguiente formulario para crear su cuenta.</p>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <?php if (isset($exito)): ?>
                    <div class="alert alert-success" role="alert">
                        <?php echo htmlspecialchars($exito); ?>
                    </div>
                <?php endif; ?>

                <form action="index.php?url=usuario/registro" method="POST" autocomplete="off">
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
                            <label for="telefono" class="form-label">Teléfono:</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="direccion" class="form-label">Dirección:</label>
                        <input type="text" class="form-control" id="direccion" name="direccion" required>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento:</label>
                            <input type="date" class="form-control" id="fecha_nacimiento" name="fecha_nacimiento" required>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="email" class="form-label">Correo electrónico:</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="password" class="form-label">Contraseña:</label>
                            <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label for="confirmar_password" class="form-label">Confirmar contraseña:</label>
                            <input type="password" class="form-control" id="confirmar_password" name="confirmar_password" required autocomplete="new-password">
                        </div>
                    </div>

                    <div class="d-grid gap-2 mt-4">
                        <button type="submit" class="btn btn-primary">Registrarse</button>
                        <button type="button" class="btn btn-secondary" onclick="location.href='index.php?url=usuario/index'">Volver al Login</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>