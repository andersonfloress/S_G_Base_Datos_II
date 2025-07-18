<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mensaje - Registro Horario</title>
    <link rel="stylesheet" href="assets/css/styles.css">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-body text-center">
                        <?php if (isset($mensaje)): ?>
                            <div class="alert alert-success">
                                <h5>✅ Éxito</h5>
                                <p><?php echo htmlspecialchars($mensaje); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <?php if (isset($error)): ?>
                            <div class="alert alert-danger">
                                <h5>❌ Error</h5>
                                <p><?php echo htmlspecialchars($error); ?></p>
                            </div>
                        <?php endif; ?>
                        
                        <a href="javascript:history.back()" class="btn btn-primary">Volver</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>