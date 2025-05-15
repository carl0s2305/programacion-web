<?php
session_start();
echo '<link rel="stylesheet" href="estilos.css">';
echo '<div class="validation-container">';

if (!isset($_SESSION['codigo']) || !isset($_POST['codigo_ingresado'])) {
    echo '<div class="message error">Sesión inválida o formulario incompleto.</div>';
    echo '<a href="index.html">Volver</a></div>';
    exit;
}

$codigo_ingresado = $_POST['codigo_ingresado'];
$codigo_correcto  = $_SESSION['codigo'];

if ($codigo_ingresado === $codigo_correcto) {
    $conn = new mysqli("localhost", "carlosperez_carlos", "pyAh2305", "carlosperez_test");
    if ($conn->connect_error) {
        echo '<div class="message error">Error de conexión: ' . $conn->connect_error . '</div>';
        exit;
    }

    $nombre   = $_SESSION['nombre'] ?? '';
    $correo   = $_SESSION['correo'] ?? '';
    $curso    = $_SESSION['curso'] ?? '';
    $password = password_hash($_SESSION['password'] ?? '', PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO usuarios (nombre_completo, correo, codigo, password) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $nombre, $correo, $codigo_correcto, $password);

    if ($stmt->execute()) {
        echo '<div class="message success">¡Registro exitoso! Código correcto y datos guardados.</div>';

        // Consulta para mostrar todos los registros
        $query = "SELECT id_usuario, nombre_completo, correo, codigo, password FROM usuarios";
        $result = $conn->query($query);

        if ($result && $result->num_rows > 0) {
            echo '<h2 style="margin-top: 20px;">Todos los usuarios registrados</h2>';
            echo '<table>';
            echo '<tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Correo</th>
                    <th>Código</th>
                    <th>Contraseña (Hash)</th>
                  </tr>';

            while ($row = $result->fetch_assoc()) {
                echo '<tr>
                        <td>' . $row['id_usuario'] . '</td>
                        <td>' . htmlspecialchars($row['nombre_completo']) . '</td>
                        <td>' . htmlspecialchars($row['correo']) . '</td>
                        <td>' . htmlspecialchars($row['codigo']) . '</td>
                        <td>' . htmlspecialchars($row['password']) . '</td>
                      </tr>';
            }

            echo '</table>';
        } else {
            echo '<div class="message error">No hay registros en la base de datos.</div>';
        }
    } else {
        echo '<div class="message error">Error al guardar: ' . $stmt->error . '</div>';
    }

    $stmt->close();
    $conn->close();
    session_unset();
    session_destroy();
} else {
    echo '<div class="message error">Código incorrecto. Intenta nuevamente.</div>';
}

echo '<a href="index.html">Volver al inicio</a></div>';
?>
