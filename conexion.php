<?php
$host = 'localhost';
$dbname = 'saludvital_api'; // Nombre de tu base de datos
$username = 'root'; // Usuario de MySQL (por defecto es 'root')
$password = ''; // Contraseña de MySQL (por defecto es vacío en XAMPP)

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['error' => 'Error en la conexión: ' . $e->getMessage()]));
}
?>