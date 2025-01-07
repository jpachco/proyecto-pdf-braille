<?php
require 'vendor/autoload.php';
require 'functions.php';

use Smalot\PdfParser\Parser;

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['pdf'])) {
    $filePath = $_FILES['pdf']['tmp_name'];
    
    $parser = new Parser();
    $pdf = $parser->parseFile($filePath);
    $text = $pdf->getText();
    
    $brailleText = textToBraille($text);

    // Guardar el texto en braille en un archivo .txt con codificación UTF-8
    $brailleFilePath = 'braille_output.txt';
    file_put_contents($brailleFilePath, "\xEF\xBB\xBF" . $brailleText);  // Incluye la BOM para UTF-8


    // Ejecutar el archivo .bat en lugar del script de Python
    $output = [];
    $return_var = 0;
    exec('C:\\xampp\\htdocs\\pdf-braille\\script.bat', $output, $return_var);

    if ($return_var !== 0) {
        echo "Error al ejecutar el archivo BAT. Código de retorno: $return_var\n";
        echo "Salida del comando:\n";
        echo implode("\n", $output);
    } else {
        echo "Script de Python ejecutado correctamente desde el archivo BAT.";
    }

    // Redirigir a la página de resultados
    session_start();
    $_SESSION['brailleText'] = $brailleText;
    header("Location: resultado.php");
    exit();
} else {
    echo "No se ha subido ningún archivo PDF.";
}
