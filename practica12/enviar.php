<?php
session_start();

$nombre = $_POST['nombre'] ?? '';
$correo = $_POST['correo'] ?? '';
$curso = $_POST['curso'] ?? '';

$codigo = rand(10000, 99999);  // Código de 5 dígitos

// Guardar datos en la sesión
$_SESSION['codigo_enviado'] = $codigo;
$_SESSION['correo'] = $correo;

// Enviar correo
$asunto = "Confirmación de inscripción al curso";
$mensaje = "Hola $nombre,\n\nGracias por inscribirte al curso de $curso.\n";
$mensaje .= "Tu código de confirmación es: $codigo\n\nIngresa este código para validar tu inscripción.\n\nSaludos.";
$cabeceras = "From: soporte@carlosperez.kesug.com\r\n";

if (mail($correo, $asunto, $mensaje, $cabeceras)) {
    echo "<h2>✅ Código enviado al correo: $correo</h2>";
    echo '<link rel="stylesheet" href="validar.css">';
    echo '<div class="validation-container">
            <h2>Validar Código de Confirmación</h2>
            <form action="validar.php" method="POST">
            <input type="text" name="codigo" placeholder="Código recibido" required>
            <button type="submit">Validar</button>
            </form>
        </div>';
} else {
    echo "<h2>❌ Error al enviar el correo. Intenta más tarde.</h2>";
}
?>
