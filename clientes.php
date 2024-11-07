<?php
include 'conexion.php';
$cnx = connection();

// Consultar los pases disponibles solo si están activos
$query = "SELECT id, NombrePase, FechaCanjeInicio, FechaCanjeFinal FROM paseslibre WHERE StockDisponible > 0 AND Estado = 1";
$stmt = $cnx->prepare($query);
$stmt->execute();
$pases = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Inicializar la variable $numpase
$numpase = '';

// Obtener el último número de pase registrado
$lastNumPaseQuery = "SELECT MAX(CAST(SUBSTRING(numpase, 6) AS UNSIGNED)) AS lastNumPase FROM clientes";
$lastNumPaseStmt = $cnx->prepare($lastNumPaseQuery);
$lastNumPaseStmt->execute();
$lastNumPase = $lastNumPaseStmt->fetch(PDO::FETCH_ASSOC)['lastNumPase'];

// Inicializar la variable $numpaseFormatted
$numpaseFormatted = "PASE-" . str_pad($lastNumPase ? $lastNumPase + 1 : 1, 5, '0', STR_PAD_LEFT); // Formato: PASE-00001

// Verificar si el número de pase ya está en uso
while (true) {
    $checkQuery = "SELECT COUNT(*) FROM clientes WHERE numpase = ?";
    $checkStmt = $cnx->prepare($checkQuery);
    $checkStmt->execute([$numpaseFormatted]);
    $count = $checkStmt->fetchColumn();

    if ($count == 0) {
        // Si no está en uso, salir del bucle
        break;
    }

    // Incrementar el número de pase
    $lastNumPase++;
    $numpaseFormatted = "PASE-" . str_pad($lastNumPase, 5, '0', STR_PAD_LEFT);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fecha = $_POST['fecha'];
    $nombre = $_POST['nombre'];
    $edad = $_POST['edad'];
    $whatsapp = $_POST['whatsapp'];
    $estado = $_POST['estado'];
    $idPase = $_POST['idPase']; // ID del pase seleccionado

    // Insertar el nuevo cliente
    $insertQuery = "INSERT INTO clientes (fecha, numpase, nombre, edad, whatsapp, estado, idPase) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $insertStmt = $cnx->prepare($insertQuery);
    $insertStmt->execute([$fecha, $numpaseFormatted, $nombre, $edad, $whatsapp, $estado, $idPase]);

    // Actualizar el Stock Disponible del pase
    $updateQuery = "UPDATE paseslibre SET StockDisponible = StockDisponible - 1 WHERE id = ?";
    $updateStmt = $cnx->prepare($updateQuery);
    $updateStmt->execute([$idPase]);

    header("Location: listar_clientes.php"); // Redirigir después de la inserción
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inscribirse</title>
    <link rel="stylesheet" href="inscripcion_estilos.css">
</head>
<body>
    <div class="container">
        <h1>Formulario de Inscripción</h1>
        <form method="POST">
            <label>Fecha:</label>
            <input type="date" id="fechaInscripcion" name="fecha" value="<?php echo date('Y-m-d'); ?>" readonly>
            <label>Número de Pase:</label>
            <input type="text" name="numpase" value="<?php echo $numpaseFormatted; ?>" readonly>
            <label>Nombre:</label>
            <input type="text" name="nombre" required>
            <label>Edad:</label>
            <input type="text" name="edad" required>
            <label>WhatsApp:</label>
            <input type="text" name="whatsapp" required>
            <label>Estado:</label>
            <select name="estado" required>
                <option value="1">Activo</option>
            </select>
            <label>Pase:</label>
            <select name="idPase" id="paseSelect" required>
                <?php foreach ($pases as $pase): ?>
                    <option value="<?php echo $pase['id']; ?>" data-fecha-inicio="<?php echo $pase['FechaCanjeInicio']; ?>" data-fecha-fin="<?php echo $pase['FechaCanjeFinal']; ?>">
                        <?php echo $pase['NombrePase']; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <label>Fecha Inicio:</label>
            <input type="date" id="fechaInicio" name="fechaIni" required readonly>
            <label>Fecha Fin:</label>
            <input type="date" id="fechaFin" name="fechaFin" required readonly>
            <button type="submit">Inscribirse</button>
            <a href="pases.php" class="btn cancel">Cancelar</a>
        </form>
    </div>

    <script>
        document.getElementById('paseSelect').addEventListener('change', function() {
            const selectedOption = this.options[this.selectedIndex];
            const fechaInicio = selectedOption.getAttribute('data-fecha-inicio');
            const fechaFin = selectedOption.getAttribute('data-fecha-fin');
            document.getElementById('fechaInicio').value = fechaInicio;
            document.getElementById('fechaFin').value = fechaFin;
        });
    </script>
</body>
</html>