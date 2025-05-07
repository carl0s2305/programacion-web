<?php
$nombre = $_POST['nombre'] ?? '';
$correo = $_POST['correo'] ?? '';
$curso = $_POST['curso'] ?? '';

// Generar número aleatorio de 5 dígitos
$codigo = rand(10000, 99999);

// Asunto y cuerpo del correo
$asunto = "Confirmación de inscripción al curso";
$mensaje = "Hola $nombre,\n\nGracias por inscribirte al curso de $curso.\n";
$mensaje .= "Tu código de confirmación es: $codigo\n\nNos vemos pronto.\n\nSaludos.";
$cabeceras = "From: soporte@carlosperez.kesug.com\r\n";

// Enviar correo
if (mail($correo, $asunto, $mensaje, $cabeceras)) {
    echo "<h2>✅ Correo enviado correctamente a $correo</h2>";
} else {
    echo "<h2>❌ Error al enviar el correo. Intenta más tarde.</h2>";
}
?>
