<?php
include 'conexion.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nombre = $_POST['nombre'];
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];
    $tipo_usuario = $_POST['tipo_usuario'];

    // Hash de la contraseña
    $clave_hashed = password_hash($clave, PASSWORD_BCRYPT);

    $sql = "INSERT INTO usuarios (nombre, correo, clave, tipo_usuario) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $nombre, $correo, $clave_hashed, $tipo_usuario);

    if ($stmt->execute()) {
        echo "Registro exitoso.";
        header('Location: index.html');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
