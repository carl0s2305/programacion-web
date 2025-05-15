<?php
session_start();

$codigo_ingresado = $_POST['codigo_ingresado'] ?? '';
$codigo_correcto  = $_SESSION['codigo'] ?? null;

// Cargar el CSS antes de cualquier lógica visual
echo '<link rel="stylesheet" href="validar.css">';
echo '<div class="validation-container">';

if ($codigo_ingresado == $codigo_correcto) {
    // Conexión a la base de datos
    $conn = new mysqli("localhost", "carlosperez_carlos", "pyAh2305", "carlosperez_test");
    if ($conn->connect_error) {
        echo '<div class="message error">❌ Error de conexión: ' . $conn->connect_error . '</div>';
        exit;
    }

    // Datos de sesión
    $nombre   = $_SESSION['nombre'] ?? '';
    $correo   = $_SESSION['correo'] ?? '';
    $curso    = $_SESSION['curso'] ?? '';
    $password = password_hash($_SESSION['password'] ?? '', PASSWORD_DEFAULT);
    $codigo   = $codigo_correcto;

    // Preparar e insertar
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre_completo, correo, codigo, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $nombre, $correo, $codigo, $password);

    if ($stmt->execute()) {
        echo '<div class="message success">✅ ¡Código correcto! Registro guardado exitosamente.</div>';
    } else {
        echo '<div class="message error">❌ Error al guardar en la base de datos: ' . $stmt->error . '</div>';
    }

    $stmt->close();
    $conn->close();
} else {
    echo '<div class="message error">❌ Código incorrecto. Intenta de nuevo.</div>';
}

echo '<a href="index.html">Volver al inicio</a>';
echo '</div>'; // Cierra .validation-container
?>
