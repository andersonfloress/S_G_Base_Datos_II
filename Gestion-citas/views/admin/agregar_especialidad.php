<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Agregar Especialidad</title>
</head>
<body>
    <h1>Agregar Especialidad</h1>
    <?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>
    <form method="post">
        <input type="text" name="nombre" placeholder="Nombre de la Especialidad" required><br>
        <button type="submit">Guardar</button><br>
        <a href="index.php?url=admin/especialidades">Volver</a>
    </form>
</body>
</html>
