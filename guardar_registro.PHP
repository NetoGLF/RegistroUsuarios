<?php
// Configura los datos de conexión
$host = 'localhost';
$dbname = 'procel_asistencia';
$username = 'root';
$password = ''; // Cambia esto si tu contraseña es distinta

// Establecer conexión
$conn = new mysqli($host, $username, $password, $dbname);

// Verificar conexión
if ($conn->connect_error) {
    die('Conexión fallida: ' . $conn->connect_error);
}

// Obtener los datos del POST
$nombre = $_POST['nombre'] ?? '';
$correo = $_POST['correo'] ?? '';
$telefono = $_POST['telefono'] ?? '';
$puesto = $_POST['puesto'] ?? '';
$empresa = $_POST['empresa'] ?? '';
$id = $_POST['id'] ?? '';

// Validar campos (simple)
if (empty($nombre) || empty($correo) || empty($telefono) || empty($puesto) || empty($empresa) || empty($id)) {
    echo 'Todos los campos son obligatorios.';
    exit;
}

// Preparar la consulta
$stmt = $conn->prepare("INSERT INTO empleados (id, nombre, correo, telefono, puesto, empresa) VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssss", $id, $nombre, $correo, $telefono, $puesto, $empresa);

// Ejecutar y responder
if ($stmt->execute()) {
    echo 'Registro exitoso';
} else {
    echo 'Error al guardar: ' . $stmt->error;
}

$stmt->close();
$conn->close();
?>


