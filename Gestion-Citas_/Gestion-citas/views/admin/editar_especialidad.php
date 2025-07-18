<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Especialidad</title>
</head>
<body>
    <h1>Editar Especialidad</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <?php if (!empty($mensaje)) echo "<p style='color:green;'>$mensaje</p>"; ?>
    
    <form method="post">
        <input type="text" name="nombre" value="<?= htmlspecialchars($especialidad["nombre"]) ?>" required><br>
        <button type="submit">Guardar</button><br>
        <a href="index.php?url=admin/especialidades">Volver</a>
    </form>
</body>
</html>