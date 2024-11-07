<?php
include 'conexion.php';
$cnx = connection();

// Consultar los datos de la tabla `paseslibre`
$query = "SELECT id, FechaCanjeInicio, FechaCanjeFinal, NombrePase, Descripcion, Stock, StockDisponible, 
                 CASE 
                     WHEN FechaCanjeFinal < NOW() THEN 0 
                     ELSE Estado 
                 END AS EstadoActual 
          FROM paseslibre";
$stmt = $cnx->prepare($query);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Pases Libres</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Menú</h2>
            <ul>
                <li><a href="clientes.php">Inscribirse</a></li> 
                <li><a href="pases.php" class="active">Pases Libres</a></li>
                <li><a href="listar_clientes.php">Clientes</a></li> 
            </ul>
        </div>
        <div class="main-content">
            <h1>Lista de Pases Libres</h1>
            <a href="crear_pase.php" class="btn">Crear Nuevo Pase</a>
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Fecha Canje Inicio</th>
                        <th>Fecha Canje Final</th>
                        <th>Nombre Pase</th>
                        <th>Descripción</th>
                        <th>Stock</th>
                        <th>Pases Disponibles</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($result as $pase): ?>
                    <tr>
                        <td><?php echo $pase['id']; ?></td>
                        <td><?php echo $pase['FechaCanjeInicio']; ?></td>
                        <td><?php echo $pase['FechaCanjeFinal']; ?></td>
                        <td><?php echo $pase['NombrePase']; ?></td>
                        <td><?php echo $pase['Descripcion']; ?></td>
                        <td><?php echo $pase['Stock']; ?></td>
                        <td><?php echo $pase['StockDisponible']; ?></td>
                        <td><?php echo $pase['EstadoActual'] ? 'Activo' : 'Inactivo'; ?></td>
                        <td>
                            <a href="editar_pase.php?id=<?php echo $pase['id']; ?>" class="btn-action edit">Editar</a>
                            <a href="eliminar_pase.php?id=<?php echo $pase['id']; ?>" class="btn-action delete" onclick="return confirm('¿Estás seguro de eliminar este pase?');">Eliminar</a>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>