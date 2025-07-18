<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Usuario</title>
</head>
<body>
    <h1>Editar Usuario</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (!empty($mensaje)) echo "<p style='color:green;'>$mensaje</p>"; ?>
    
    <form method="post">
        <input type="text" name="nombre" value="<?= htmlspecialchars($usuario["nombre"]) ?>" required><br>
        <input type="text" name="apellido" value="<?= htmlspecialchars($usuario["apellido"]) ?>" required><br>
        <input type="text" name="dni" value="<?= htmlspecialchars($usuario["dni"]) ?>" required><br>
        <input type="email" name="email" value="<?= htmlspecialchars($usuario["email"]) ?>" required><br>
        <input type="password" name="password" placeholder="Nueva contraseña (opcional)"><br>
        <input type="text" name="telefono" value="<?= htmlspecialchars($usuario["telefono"]) ?>"><br>
        <input type="text" name="direccion" value="<?= htmlspecialchars($usuario["direccion"]) ?>"><br>
        <input type="date" name="fecha_nacimiento" value="<?= htmlspecialchars($usuario["fecha_nacimiento"]) ?>"><br>
        
        <select name="rol_id" required>
            <option value="2" <?= $usuario["rol_id"] == 2 ? "selected" : "" ?>>Médico</option>
            <option value="3" <?= $usuario["rol_id"] == 3 ? "selected" : "" ?>>Enfermera</option>
            <option value="4" <?= $usuario["rol_id"] == 4 ? "selected" : "" ?>>Recepcionista</option>
            <option value="6" <?= $usuario["rol_id"] == 6 ? "selected" : "" ?>>Especialista de Exámenes</option> <!-- Opción añadida -->
        </select><br>

        <button type="submit">Guardar</button><br>
        <a href="index.php?url=admin/usuarios">Volver</a>
    </form>
</body>
</html>
