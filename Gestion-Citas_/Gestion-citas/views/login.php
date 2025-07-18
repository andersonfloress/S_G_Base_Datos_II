<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión - Gestión de Citas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid d-flex justify-content-center align-items-center min-vh-100">
        <div class="card shadow-custom" style="max-width: 400px; width: 100%;">
            <div class="card-header text-center">
                <h1 class="text-white mb-0">Gestión de Citas</h1>
            </div>
            <div class="card-body">
                <h2 class="text-center mb-4">Iniciar Sesión</h2>

                <?php if (isset($error)): ?>
                    <div class="alert alert-danger" role="alert">
                        <?php echo htmlspecialchars($error); ?>
                    </div>
                <?php endif; ?>

                <form action="index.php?url=usuario/login" method="POST" autocomplete="off">
                    <div class="mb-3">
                        <label for="email" class="form-label">Correo electrónico:</label>
                        <input type="email" class="form-control" id="email" name="email" required autocomplete="email">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Contraseña:</label>
                        <input type="password" class="form-control" id="password" name="password" required autocomplete="new-password">
                    </div>

                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary">Iniciar Sesión</button>
                        <button type="button" class="btn btn-secondary" onclick="location.href='index.php?url=usuario/registro'">Registrarse</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>
</html>