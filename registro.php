<?php
header('Content-Type: application/json');
require 'conexion.php';

try {
    // Leer los datos enviados en el cuerpo de la solicitud
    $data = json_decode(file_get_contents('php://input'), true);

    // Verificar si el JSON es válido
    if (json_last_error() !== JSON_ERROR_NONE) {
        echo json_encode(['error' => 'Error en el formato JSON: ' . json_last_error_msg()]);
        exit;
    }

    // Validar que los campos requeridos estén presentes
    if (isset($data['tipo_documento'], $data['documento'], $data['password'])) {
        $tipo_documento = $data['tipo_documento'];
        $documento = $data['documento'];
        $password = md5($data['password']); // Encriptar la contraseña con MD5 (no recomendado para producción)

        // Validar que los campos no estén vacíos
        if (empty($tipo_documento) || empty($documento) || empty($password)) {
            echo json_encode(['error' => 'Todos los campos son obligatorios']);
            exit;
        }

        // Insertar el nuevo usuario en la base de datos
        $query = "INSERT INTO usuarios (tipo_documento, documento, password) VALUES (?, ?, ?)";
        $stmt = $conexion->prepare($query);
        $stmt->execute([$tipo_documento, $documento, $password]);

        // Verificar si el registro fue exitoso
        if ($stmt->rowCount() > 0) {
            echo json_encode(['message' => 'Registro exitoso']);
        } else {
            echo json_encode(['error' => 'No se pudo registrar el usuario']);
        }
    } else {
        echo json_encode(['error' => 'Datos incompletos']);
    }
} catch (PDOException $e) {
    // Manejar errores de la base de datos
    if ($e->getCode() == 23000) { // Código de error para clave duplicada
        echo json_encode(['error' => 'El usuario ya existe']);
    } else {
        echo json_encode(['error' => 'Error en el registro: ' . $e->getMessage()]);
    }
} catch (Exception $e) {
    // Manejar cualquier otro error
    echo json_encode(['error' => 'Error inesperado: ' . $e->getMessage()]);
}
?>