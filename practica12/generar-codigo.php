<?php
session_start();

$nombre    = $_POST['nombre'] ?? '';
$correo    = $_POST['correo'] ?? '';
$curso     = $_POST['curso'] ?? '';
$password  = $_POST['password'] ?? '';

function generarCodigo($longitud = 5) {
    $caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $codigo = '';
    for ($i = 0; $i < $longitud; $i++) {
        $codigo .= $caracteres[random_int(0, strlen($caracteres) - 1)];
    }
    return $codigo;
}

$codigo = generarCodigo();


// Guardar en sesión
$_SESSION['nombre']   = $nombre;
$_SESSION['correo']   = $correo;
$_SESSION['curso']    = $curso;
$_SESSION['password'] = $password;
$_SESSION['codigo']   = $codigo;

// Enviar correo
$asunto = "Confirmación de inscripción al curso";
$mensaje = "Hola $nombre,\n\nGracias por inscribirte al curso de $curso.\n";
$mensaje .= "Tu código de confirmación es: $codigo\n\nIngresa este código para validar tu inscripción.\n\nSaludos.";
$cabeceras = "From: soporte@carlosperez.kesug.com\r\n";

if (mail($correo, $asunto, $mensaje, $cabeceras)) {
    echo "<h2>Código enviado al correo: $correo</h2>";
    echo '<link rel="stylesheet" href="estilos.css">';
    echo '<div class="validation-container">
            <h2>Validar Código de Confirmación</h2>
            <form action="validar-codigo.php" method="POST">
                <input type="text" name="codigo_ingresado" placeholder="Código recibido" required>
                <button type="submit">Validar</button>
            </form>
          </div>';
} else {
    echo "<h2>Error al intentar enviar el correo.</h2>";
}
?>
