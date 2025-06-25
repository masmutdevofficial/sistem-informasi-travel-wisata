<?php
$logDir = dirname(__DIR__) . '/logs';
$logFile = $logDir . '/error.log';

if (!is_dir($logDir)) {
    mkdir($logDir, 0775, true);
}

if (!file_exists($logFile)) {
    touch($logFile);
    chmod($logFile, 0664);
}

// Set timezone
date_default_timezone_set('Asia/Jakarta');

// Atur limit PHP
ini_set('max_execution_time', 300);     // Maks 5 menit
ini_set('memory_limit', '256M');        // Batas memori
ini_set('post_max_size', '64M');        // Maks ukuran POST
ini_set('upload_max_filesize', '64M');  // Maks ukuran upload
ini_set('display_errors', 1);
// Set error log
ini_set('log_errors', 1);
ini_set('error_log', $logFile);
error_reporting(E_ALL);

// Custom error handler
set_error_handler(function ($severity, $message, $file, $line) use ($logFile) {
    $date = date('Y-m-d H:i:s');
    $errorType = match ($severity) {
        E_ERROR             => 'ERROR',
        E_WARNING           => 'WARNING',
        E_PARSE             => 'PARSE',
        E_NOTICE            => 'NOTICE',
        E_CORE_ERROR        => 'CORE_ERROR',
        E_CORE_WARNING      => 'CORE_WARNING',
        E_COMPILE_ERROR     => 'COMPILE_ERROR',
        E_COMPILE_WARNING   => 'COMPILE_WARNING',
        E_USER_ERROR        => 'USER_ERROR',
        E_USER_WARNING      => 'USER_WARNING',
        E_USER_NOTICE       => 'USER_NOTICE',
        E_STRICT            => 'STRICT',
        E_RECOVERABLE_ERROR => 'RECOVERABLE_ERROR',
        default             => 'UNKNOWN_ERROR',
    };

    $logMsg = "[$date] [$errorType] $message in $file on line $line" . PHP_EOL;
    error_log($logMsg, 3, $logFile);
});

// Tangani fatal error
register_shutdown_function(function () use ($logFile) {
    $error = error_get_last();
    if ($error && in_array($error['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        $date = date('Y-m-d H:i:s');
        $logMsg = "[$date] [FATAL] {$error['message']} in {$error['file']} on line {$error['line']}" . PHP_EOL;
        error_log($logMsg, 3, $logFile);
    }
});
?>