<?php
session_start();

$codigo_ingresado = $_POST['codigo'] ?? '';
$codigo_enviado = $_SESSION['codigo_enviado'] ?? null;

if ($codigo_ingresado == $codigo_enviado) {
    echo "<h2>✅ ¡Código correcto! Inscripción validada.</h2>";
} else {
    echo "<h2>❌ Código incorrecto. Intenta nuevamente.</h2>";
    echo '<a href="index.html">Volver al formulario</a>';
}
?>
