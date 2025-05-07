<?php
session_start();

$codigo_ingresado = $_POST['codigo'] ?? '';
$codigo_enviado = $_SESSION['codigo_enviado'] ?? null;

if ($codigo_ingresado == $codigo_enviado) {
    echo '<link rel="stylesheet" href="validar.css">';
    echo '<div class="validation-container">';

    if ($codigo_ingresado == $codigo_enviado) {
        echo '<div class="message success">✅ ¡Código correcto! Inscripción validada.</div>';
    } else {
        echo '<div class="message error">❌ Código incorrecto. Intenta nuevamente.</div>';
        echo '<a href="index.html">Volver al formulario</a>';
}

echo '</div>';

}
?>
