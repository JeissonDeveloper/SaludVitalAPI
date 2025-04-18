<?php
$host = 'localhost';
$dbname = 'saludvital_api'; // Asegúrate de que este sea el nombre correcto de tu base de datos
$username = 'root'; // Cambia esto si tienes un usuario diferente
$password = ''; // Cambia esto si tienes una contraseña configurada

try {
    $conexion = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die(json_encode(['error' => 'Error en la conexión: ' . $e->getMessage()]));
}
?>