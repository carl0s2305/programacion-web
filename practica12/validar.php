<?php
session_start();

$codigo_ingresado = $_POST['codigo_ingresado'] ?? '';
$codigo_correcto  = $_SESSION['codigo'] ?? null;

if ($codigo_ingresado == $codigo_correcto) {
    // Conexión a la base de datos
    $conn = new mysqli("localhost", "carlosperez_carlos", "pyAh2305", "carlosperez_test");
    if ($conn->connect_error) {
        die("❌ Error al conectar: " . $conn->connect_error);
    }

    // Recuperar datos de sesión
    $nombre   = $_SESSION['nombre'];
    $correo   = $_SESSION['correo'];
    $curso    = $_SESSION['curso'];
    $password = $_SESSION['password'];
    $codigo   = $codigo_correcto;

    // Insertar en la tabla
    $stmt = $conn->prepare("INSERT INTO usuarios (nombre_completo, correo, codigo, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssis", $nombre, $correo, $codigo, $password);

    echo '<link rel="stylesheet" href="validar.css">';
    echo '<div class="validation-container">';

    if ($stmt->execute()) {
        echo '<div class="message success">✅ ¡Código correcto! Inscripción guardada.</div>';
    } else {
        echo '<div class="message error">❌ Error al guardar en la base: ' . $stmt->error . '</div>';
    }

    echo '<a href="index.html">Volver al inicio</a></div>';

    $stmt->close();
    $conn->close();
} else {
    echo '<link rel="stylesheet" href="validar.css">';
    echo '<div class="validation-container">';
    echo '<div class="message error">❌ Código incorrecto. Intenta de nuevo.</div>';
    echo '<a href="index.html">Volver al formulario</a></div>';
}
?>
