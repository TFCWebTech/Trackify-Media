<?php
echo "<h1>Laravel Logs Check</h1>";

$logFiles = [
    __DIR__ . '/../storage/logs/laravel.log',
    __DIR__ . '/../storage/logs/laravel-' . date('Y-m-d') . '.log'
];

foreach ($logFiles as $logFile) {
    if (file_exists($logFile)) {
        echo "<h2>Log file: " . basename($logFile) . "</h2>";
        echo "<pre>";
        // Show last 20 lines
        $lines = file($logFile);
        $lastLines = array_slice($lines, -20);
        foreach ($lastLines as $line) {
            echo htmlspecialchars($line);
        }
        echo "</pre>";
    } else {
        echo "<p>✗ " . basename($logFile) . " not found</p>";
    }
}
?>