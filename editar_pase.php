<?php
include 'conexion.php';
$cnx = connection();

$id = $_GET['id'];
$query = "SELECT * FROM paseslibre WHERE id = ?";
$stmt = $cnx->prepare($query);
$stmt->execute([$id]);
$pase = $stmt->fetch(PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $fechaInicio = $_POST['FechaCanjeInicio'];
    $fechaFinal = $_POST['FechaCanjeFinal'];
    $nombrePase = $_POST['NombrePase'];
    $descripcion = $_POST['Descripcion'];
    $stock = $_POST['Stock'];
    $stockDisponible = $_POST['StockDisponible'];
    $estado = $_POST['Estado'];

    $query = "UPDATE paseslibre SET FechaCanjeInicio = ?, FechaCanjeFinal = ?, NombrePase = ?, Descripcion = ?, Stock = ?, StockDisponible = ?, Estado = ? WHERE id = ?";
    $stmt = $cnx->prepare($query);
    $stmt->execute([$fechaInicio, $fechaFinal, $nombrePase, $descripcion, $stock, $stockDisponible, $estado, $id]);

    header("Location: pases.php");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Pase Libre</title>
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="editar_pase.css"> <!-- Enlace al archivo CSS específico -->
</head>
<body>
    <div class="container">
        <h1>Editar Pase Libre</h1>
        <form method="POST">
            <label>Fecha Canje Inicio:</label>
            <input type="date" name="FechaCanjeInicio" value="<?php echo $pase['FechaCanjeInicio']; ?>" required>
            <label>Fecha Canje Final:</label>
            <input type="date" name="FechaCanjeFinal" value="<?php echo $pase['FechaCanjeFinal']; ?>" required>
            <label>Nombre Pase:</label>
            <input type="text" name="NombrePase" value="<?php echo $pase['NombrePase']; ?>" required>
            <label>Descripción:</label>
            <textarea name="Descripcion"><?php echo $pase['Descripcion']; ?></textarea>
            <label>Stock:</label>
            <input type="number" name="Stock" value="<?php echo $pase['Stock']; ?>" required>
            <label>Stock Disponible:</label>
            <input type="number" name="StockDisponible" value="<?php echo $pase['StockDisponible']; ?>" required>
            <label>Estado:</label>
            <select name="Estado">
                <option value="1" <?php echo $pase['Estado'] ? 'selected' : ''; ?>>Activo</option>
                <option value="0" <?php echo !$pase['Estado'] ? 'selected' : ''; ?>>Inactivo</option>
            </select>
            <button type="submit">Actualizar Pase</button>
            <a href="pases.php" class="btn cancel">Cancelar</a> <!-- Botón Cancelar -->
        </form>
    </div>
</body>
</html>