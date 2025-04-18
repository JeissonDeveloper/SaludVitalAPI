<?php
header('Content-Type: application/json');
require 'conexion.php';

$data = json_decode(file_get_contents('php://input'), true);

if (isset($data['tipo_documento'], $data['documento'], $data['password'])) {
    $tipo_documento = $data['tipo_documento'];
    $documento = $data['documento'];
    $password = md5($data['password']); // Encriptar la contraseña

    try {
        $query = "SELECT * FROM usuarios WHERE tipo_documento = ? AND documento = ? AND password = ?";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$tipo_documento, $documento, $password]);

        if ($stmt->rowCount() > 0) {
            echo json_encode(['message' => 'Autenticación satisfactoria']);
        } else {
            echo json_encode(['error' => 'Error en la autenticación']);
        }
    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error en la consulta: ' . $e->getMessage()]);
    }
} else {
    echo json_encode(['error' => 'Datos incompletos']);
}
?>