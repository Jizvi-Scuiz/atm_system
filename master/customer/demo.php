<?php
function generateRandomNumber($length = 12) {
    $number = '';
    for ($i = 0; $i < $length; $i++) {
        $number .= random_int(0, 9);
    }
    return $number;
}

$randomNumber = generateRandomNumber();
echo $randomNumber;
?>