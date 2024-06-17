<?php
include 'conexion.php';
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = $_POST['correo'];
    $clave = $_POST['clave'];

    $sql = "SELECT id, tipo_usuario, nombre, clave FROM usuarios WHERE correo = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $correo);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($clave, $row['clave'])) {
            $_SESSION['usuario_id'] = $row['id'];
            $_SESSION['tipo_usuario'] = $row['tipo_usuario'];
            $_SESSION['nombre'] = $row['nombre'];

            // Redirigir al usuario dependiendo del tipo
            switch ($row['tipo_usuario']) {
                case 'admin':
                    header("Location: cargar_productos.html");
                    break;
                case 'vendedor':
                    header("Location: pos.html");
                    break;
                case 'tecnico':
                    header("Location: tecnico.html");
                    break;
                case 'gerente':
                    header("Location: gerente.html");
                    break;
                default:
                    echo "Tipo de usuario no válido.";
                    break;
            }
            exit();
        } else {
            echo "Contraseña incorrecta.";
        }
    } else {
        echo "Correo no registrado.";
    }
}
$conn->close();
?>
