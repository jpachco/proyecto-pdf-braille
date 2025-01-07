<?php
session_start();
$brailleText = $_SESSION['brailleText'] ?? 'No se ha generado texto en braille.';
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="css/style.css">
    <title>Resultado en Braille</title>
    <script src="js/voiceHandler.js" defer></script> <!-- Para la funcionalidad de voz -->
</head>
<body>
    <div class="resultado-container">
        <h2>Resultado en Braille:</h2>
        <div class="braille-output">
            <p><?= nl2br(htmlspecialchars($brailleText)); ?></p>
        </div>
        <a href="index.html" id="btnConvertirOtro">Convertir otro archivo</a>
    </div>
</body>
</html>
