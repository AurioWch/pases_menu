<?php
include 'conexion.php';
$cnx = connection();

// Consultar los datos de la tabla `clientes`
$query = "SELECT * FROM clientes";
$stmt = $cnx->prepare($query);
$stmt->execute();
$clientes = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Clientes</title>
    <link rel="stylesheet" href="listar_est_cli.css">
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h2>Menú</h2>
            <ul>
                <li><a href="clientes.php">Inscribirse</a></li> 
                <li><a href="pases.php">Pases Libres</a></li>
                <li><a href="listar_clientes.php" class="active">Clientes</a></li> 
            </ul>
        </div>
        <div class="main-content">
            <h1>Lista de Clientes</h1>
            <table>
                <thead>
                    <tr>
                        <th>ID Cliente</th>
                        <th>Fecha</th>
                        <th>Número de Pase</th>
                        <th>Nombre</th>
                        <th>Edad</th>
                        <th>WhatsApp</th>
                        <th>Estado</th>
                        <th>Fecha Inicio</th>
                        <th>Fecha Fin</th>
                        <th>Nombre Pase</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($clientes as $cliente): ?>
                    <tr>
                        <td><?php echo $cliente['idCliente']; ?></td>
                        <td><?php echo $cliente['fecha']; ?></td>
                        <td><?php echo $cliente['numpase']; ?></td>
                        <td><?php echo $cliente['nombre']; ?></td>
                        <td><?php echo $cliente['edad']; ?></td>
                        <td><?php echo $cliente['whatsapp']; ?></td>
                        <td><?php echo $cliente['estado'] == '1' ? 'Activo' : 'Inactivo'; ?></td>
                        <td><?php echo $cliente['fechaIni']; ?></td>
                        <td><?php echo $cliente['fechaFin']; ?></td>
                        <td><?php echo $cliente['NombrePase']; ?></td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>