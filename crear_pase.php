<?php
include 'conexion.php';
$cnx = connection();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fechaInicio = $_POST['FechaCanjeInicio'];
    $fechaFinal = $_POST['FechaCanjeFinal'];
    $nombrePase = $_POST['NombrePase'];
    $descripcion = $_POST['Descripcion'];
    $stock = $_POST['Stock'];
    $stockDisponible = $_POST['StockDisponible'];
    $estado = $_POST['Estado'];

    $query = "INSERT INTO paseslibre (FechaCanjeInicio, FechaCanjeFinal, NombrePase, Descripcion, Stock, StockDisponible, Estado) VALUES (?, ?, ?, ?, ?, ?, ?)";
    $stmt = $cnx->prepare($query);
    $stmt->execute([$fechaInicio, $fechaFinal, $nombrePase, $descripcion, $stock, $stockDisponible, $estado]);

    header("Location: pases.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Pase Libre</title>
    <link rel="stylesheet" href="styles.css"> <!-- Enlace al archivo CSS principal -->
    <link rel="stylesheet" href="crear_pase.css"> <!-- Enlace al archivo CSS específico -->
    <script>
        function setMinDate() {
            const today = new Date();
            const dd = String(today.getDate()).padStart(2, '0');
            const mm = String(today.getMonth() + 1).padStart(2, '0'); // Enero es 0
            const yyyy = today.getFullYear();
            const minDate = yyyy + '-' + mm + '-' + dd;
            document.getElementById("fechaFinal").setAttribute("min", minDate);
        }
    </script>
</head>
<body onload="setMinDate()">
    <div class="container">
        <div class="sidebar">
            <h2>Menú</h2>
            <ul>
                <li><a href="clientes.php">Clientes</a></li>
                <li><a href="pases.php" class="active">Pases Libres</a></li>
            </ul>
        </div>
        <div class="main-content">
            <h1>Crear Pase Libre</h1>
            <form method="POST">
                <label>Fecha Canje Inicio:</label>
                <input type="date" name="FechaCanjeInicio" required>
                <label>Fecha Canje Final:</label>
                <input type="date" id="fechaFinal" name="FechaCanjeFinal" required>
                <label>Nombre Pase:</label>
                <input type="text" name="NombrePase" required>
                <label>Descripción:</label>
                <textarea name="Descripcion"></textarea>
                <label>Stock:</label>
                <input type="number" name="Stock" required>
                <label>Stock Disponible:</label>
                <input type="number" name="StockDisponible" required>
                <label>Estado:</label>
                <select name="Estado">
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
                <button type="submit">Crear Pase</button>
                <a href="pases.php" class="btn cancel">Cancelar</a> <!-- Botón Cancelar -->
            </form>
        </div>
    </div>
</body>
</html>