<?php
// Conexión a la base de datos (ajusta según tus datos de conexión)
$host = 'localhost';
$dbname = 'nombre_bd';
$username = 'usuario';
$password = 'contraseña';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Obtén los datos recibidos
    $data = json_decode(file_get_contents("php://input"), true);

    if (isset($data['nombre'], $data['email'], $data['telefono'], $data['puesto'])) {
        // Inserción en la base de datos
        $query = "INSERT INTO usuarios (nombre, email, telefono, puesto) VALUES (:nombre, :email, :telefono, :puesto)";
        $stmt = $pdo->prepare($query);

        $stmt->bindParam(':nombre', $data['nombre']);
        $stmt->bindParam(':email', $data['email']);
        $stmt->bindParam(':telefono', $data['telefono']);
        $stmt->bindParam(':puesto', $data['puesto']);

        $stmt->execute();

        // Devolver el ID del usuario registrado
        $id = $pdo->lastInsertId();
        echo json_encode(['success' => true, 'id' => $id]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Datos incompletos']);
    }
} catch (PDOException $e) {
    echo json_encode(['success' => false, 'error' => $e->getMessage()]);
}
?>

