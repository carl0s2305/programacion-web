<?php
session_start();

// Cargar CSS visual
echo '<link rel="stylesheet" href="validar.css">';
echo '<div class="validation-container">';

// Verificar que haya código en la sesión
if (!isset($_SESSION['codigo']) || !isset($_POST['codigo_ingresado'])) {
    echo '<div class="message error">❌ Sesión inválida o formulario incompleto.</div>';
    echo '<a href="index.html">Volver</a></div>';
    exit;
}

$codigo_ingresado = $_POST['codigo_ingresado'];
$codigo_correcto  = $_SESSION['codigo'];

// Validación del código
if ($codigo_ingresado == $codigo_correcto) {
    // Conexión
    $conn = new mysqli("localhost", "carlosperez_carlos", "pyAh2305", "carlosperez_test");
    if ($conn->connect_error) {
        echo '<div class="message error">❌ Error de conexión: ' . $conn->connect_error . '</div>';
        exit;
    }

    // Recuperar datos
    $nombre   = $_SESSION['nombre'] ?? '';
    $correo   = $_SESSION['correo'] ?? '';
    $curso    = $_SESSION['curso'] ?? '';
    $password = password_hash($_SESSION['password'] ?? '', PASSWORD_DEFAULT); // HASH aquí ✅

    // Insertar
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre_completo, correo, codigo, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $nombre, $correo, $codigo_correcto, $password);

    if ($stmt->execute()) {
        echo '<div class="message success">✅ ¡Registro exitoso! Código correcto y datos guardados.</div>';
    } else {
        echo '<div class="message error">❌ Error al guardar: ' . $stmt->error . '</div>';
    }

    $stmt->close();
    $conn->close();
} else {
    echo '<div class="message error">❌ Código incorrecto. Intenta nuevamente.</div>';
}

echo '<a href="index.html">Volver al inicio</a></div>';
