<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Notificaciones - Gestión de Citas</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <div class="container-fluid">
        <div class="main-content">
            <h1>Mis Notificaciones</h1>

            <div class="card">
                <div class="card-header">
                    <h3 class="text-white mb-0">Notificaciones del Sistema</h3>
                </div>
                <div class="card-body">
                    <?php if (!empty($notificaciones)): ?>
                        <div class="list-group">
                            <?php foreach ($notificaciones as $notif): ?>
                                <div class="list-group-item">
                                    <div class="d-flex w-100 justify-content-between">
                                        <p class="mb-1"><?php echo htmlspecialchars($notif['mensaje']); ?></p>
                                        <small class="text-muted"><?php echo htmlspecialchars($notif['fecha_envio']); ?></small>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <small class="text-muted">Estado: 
                                            <?php 
                                            if ($notif['estado'] == 'leida') {
                                                echo '<span class="badge bg-success">Leída</span>';
                                            } else {
                                                echo '<span class="badge bg-warning">No leída</span>';
                                            }
                                            ?>
                                        </small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-muted">No tienes notificaciones.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="text-center mt-4">
                <a href="index.php?url=usuario/dashboard" class="btn btn-secondary">Volver al Dashboard</a>
            </div>
        </div>
    </div>
</body>
</html>