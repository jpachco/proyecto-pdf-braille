<?php
function textToBraille($text) {
    $brailleMap = [// Biblioteca de valores
        'a' => '⠁', 'b' => '⠃', 'c' => '⠉', 'd' => '⠙', 'e' => '⠑',
        'f' => '⠋', 'g' => '⠛', 'h' => '⠓', 'i' => '⠊', 'j' => '⠚',
        'k' => '⠅', 'l' => '⠇', 'm' => '⠍', 'n' => '⠝', 'o' => '⠕',
        'p' => '⠏', 'q' => '⠟', 'r' => '⠗', 's' => '⠎', 't' => '⠞',
        'u' => '⠥', 'v' => '⠧', 'w' => '⠺', 'x' => '⠭', 'y' => '⠽', 'z' => '⠵',
        ' ' => ' ', // Espacio
    ];
    
    $brailleText = '';
    $text = strtolower($text); // Convertir a minúsculas

    foreach (str_split($text) as $char) {
        $brailleText .= $brailleMap[$char] ?? ''; // Convertir cada carácter
    }
    
    return $brailleText;
}
?>
