<!-- Archivo: /Gestion-Citas/views/recepcionista/registrar_paciente.php -->

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Nuevo Paciente</title>
    <link rel="stylesheet" href="assets/css/recepcionista.css">
</head>
<body>
    <h2>Registrar Nuevo Paciente</h2>

    <?php if (isset($error)): ?>
        <p style="color:red;"><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <?php if (isset($exito)): ?>
        <p style="color:green;"><?= htmlspecialchars($exito) ?></p>
    <?php endif; ?>

    <!-- CORRECCIÓN: Se añade action explícito -->
    <form method="POST" action="index.php?url=recepcionista/registrar_paciente">
        <label>Nombre:</label><br>
        <input type="text" name="nombre" required><br><br>

        <label>Apellido:</label><br>
        <input type="text" name="apellido" required><br><br>

        <label>DNI:</label><br>
        <input type="text" name="dni" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Contraseña:</label><br>
        <input type="password" name="password" required><br><br>

        <label>Teléfono:</label><br>
        <input type="text" name="telefono"><br><br>

        <label>Dirección:</label><br>
        <input type="text" name="direccion"><br><br>

        <label>Fecha de nacimiento:</label><br>
        <input type="date" name="fecha_nacimiento"><br><br>

        <button type="submit" name="registrar_paciente">Registrar Paciente</button>
    </form>

    <br>
    <a href="index.php?url=recepcionista/dashboard">Volver al Dashboard</a>
</body>
</html>
