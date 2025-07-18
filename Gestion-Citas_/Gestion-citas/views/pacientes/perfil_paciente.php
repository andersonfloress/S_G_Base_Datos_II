<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Perfil del Paciente - Gestión de Citas</title>
    
    <link rel="stylesheet" href="assets/css/paciente.css">
</head>
<body>
    <div class="profile-box">
        <h1>Mi Perfil</h1>

        <?php if (isset($mensaje)): ?>
            <p style="color:green;"><?php echo htmlspecialchars($mensaje); ?></p>
        <?php endif; ?>

        <?php if (isset($error)): ?>
            <p style="color:red;"><?php echo htmlspecialchars($error); ?></p>
        <?php endif; ?>

        <form action="index.php?url=paciente/perfil" method="POST">
            <label>Nombre:</label><br>
            <input type="text" name="nombre" value="<?php echo htmlspecialchars($paciente['nombre']); ?>" required><br><br>

            <label>Apellido:</label><br>
            <input type="text" name="apellido" value="<?php echo htmlspecialchars($paciente['apellido']); ?>" required><br><br>

            <label>DNI:</label><br>
            <input type="text" name="dni" value="<?php echo htmlspecialchars($paciente['dni']); ?>" required><br><br>

            <label>Teléfono:</label><br>
            <input type="text" name="telefono" value="<?php echo htmlspecialchars($paciente['telefono']); ?>" required><br><br>

            <label>Dirección:</label><br>
            <input type="text" name="direccion" value="<?php echo htmlspecialchars($paciente['direccion']); ?>" required><br><br>

            <label>Fecha de Nacimiento:</label><br>
            <input type="date" name="fecha_nacimiento" value="<?php echo htmlspecialchars($paciente['fecha_nacimiento']); ?>" required><br><br>

            <label>Correo Electrónico:</label><br>
            <input type="email" name="email" value="<?php echo htmlspecialchars($paciente['email']); ?>" required><br><br>

            <button type="submit">Actualizar Perfil</button>
            <button type="button" onclick="location.href='index.php?url=paciente/dashboard'">Volver al Dashboard</button>
        </form>
    </div>
</body>
</html>
