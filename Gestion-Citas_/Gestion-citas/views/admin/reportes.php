<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes</title>
</head>
<body>
    <h1>Reportes y Estadísticas</h1>
    
    <div>
        <a href="index.php?url=admin/dashboard">Volver al Dashboard</a>
    </div>
    
    <div>
        <h2>Estadísticas Generales</h2>
        <div>
            <h3>Resumen de Usuarios</h3>
            <p>Total de Pacientes: <?= $totalPacientes ?? 0 ?></p>
            <p>Total de Médicos: <?= $totalMedicos ?? 0 ?></p>
            <p>Total de Enfermeras: <?= $totalEnfermeras ?? 0 ?></p>
            <p>Total de Recepcionistas: <?= $totalRecepcionistas ?? 0 ?></p>
        </div>
        
        <div>
            <h3>Citas Médicas</h3>
            <p>Total de Citas: <?= $totalCitas ?? 0 ?></p>
            <p>Citas Pendientes: <?= $citasPendientes ?? 0 ?></p>
            <p>Citas Completadas: <?= $citasCompletadas ?? 0 ?></p>
        </div>
        
        <div>
            <h3>Especialidades</h3>
            <p>Total de Especialidades: <?= $totalEspecialidades ?? 0 ?></p>
        </div>
    </div>
    
    <!-- Aquí puedes agregar más reportes específicos -->
</body>
</html>