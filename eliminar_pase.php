<?php
include 'conexion.php';
$cnx = connection();

$id = $_GET['id'];

// Primero, obtener el stock del pase que se va a eliminar
$queryStock = "SELECT Stock FROM paseslibre WHERE id = ?";
$stmtStock = $cnx->prepare($queryStock);
$stmtStock->execute([$id]);
$stock = $stmtStock->fetch(PDO::FETCH_ASSOC)['Stock'];

// Incrementar el stock disponible
$queryUpdateStock = "UPDATE paseslibre SET StockDisponible = StockDisponible + 1 WHERE id = ?";
$stmtUpdateStock = $cnx->prepare($queryUpdateStock);
$stmtUpdateStock->execute([$id]);

// Ahora eliminar el pase
$query = "DELETE FROM paseslibre WHERE id = ?";
$stmt = $cnx->prepare($query);
$stmt->execute([$id]);

header("Location: pases.php");
?>