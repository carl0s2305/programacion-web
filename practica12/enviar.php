<?php
session_start();

// Obtener datos del formulario
$nombre    = $_POST['nombre'] ?? '';
$correo    = $_POST['correo'] ?? '';
$curso     = $_POST['curso'] ?? '';
$password  = $_POST['password'] ?? '';

// Generar código de confirmación
$codigo = rand(10000, 99999);

// Guardar en sesión
$_SESSION['codigo_enviado'] = $codigo;
$_SESSION['correo'] = $correo;

// Conexión a la base de datos
$host = "localhost";
$usuario = "carlosperez_carlos";
$contrasena = "pyAh2305";
$basedatos = "carlosperez_test";

$conn = new mysqli($host, $usuario, $contrasena, $basedatos);
if ($conn->connect_error) {
    die("❌ Error de conexión: " . $conn->connect_error);
}

// Insertar datos en la tabla 'usuarios'
$stmt = $conn->prepare("INSERT INTO usuarios (nombre_completo, correo, codigo, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssis", $nombre, $correo, $codigo, $password);

if ($stmt->execute()) {
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
        echo "<h2>❌ Error al enviar el correo.</h2>";
    }
} else {
    echo "❌ Error al insertar en la base de datos: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
