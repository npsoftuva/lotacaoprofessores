<?php
function strDateFromPor2Eng($date, $outDelimiter="/"){  
    $dateArray = explode("/", $date);
    return $dateArray[1].$outDelimiter.$dateArray[0].$outDelimiter.$dateArray[2];
}
?>