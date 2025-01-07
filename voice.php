<?php
if (isset($_GET['action'])) {
    $action = $_GET['action'];

    // Mensajes de voz según la acción
    $messages = [
        'select' => "Selecciona un archivo PDF para convertir a Braille.",
        'convert' => "Convierte el archivo PDF a texto Braille.",
        'convert_otro' => "Regresa a la página inicial para convertir otro archivo PDF."
    ];

    // Verifica si la acción está definida en los mensajes
    if (array_key_exists($action, $messages)) {
        $message = $messages[$action];
        
        // Ruta completa al archivo .bat
        $batFilePath = "C:\\xampp\\htdocs\\pdf-braille\\text_to_speech.bat"; // Asegúrate de que sea la ruta correcta

        // Comprueba si el archivo .bat existe
        if (file_exists($batFilePath)) {
            // Ejecuta el archivo .bat con el mensaje como argumento
            exec("cmd /c $batFilePath " . escapeshellarg($message), $output, $return_var);

            // Verifica el resultado del comando
            if ($return_var === 0) {
                echo "Comando ejecutado con éxito: $message";
            } else {
                echo "Error al ejecutar el comando. Código de salida: $return_var";
            }
        } else {
            echo "Error: No se encontró el archivo .bat en la ruta especificada.";
        }
    } else {
        echo "Acción no reconocida: $action.";
    }
} else {
    echo "No se recibió ninguna acción.";
}
?>
