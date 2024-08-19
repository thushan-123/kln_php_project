<?php 

function logger($level, $message) {
    // Create a log file 
    $file = __DIR__ . "/../logs/logs.log";
    $date = date("Y-m-d H:i:s");

    // Set a formatter 
    $log_msg = "[$date]  [$level] - $message" . PHP_EOL;

    file_put_contents($file, $log_msg, FILE_APPEND);
}

?>
