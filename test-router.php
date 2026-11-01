<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

try {
    // Load Laravel
    require __DIR__ . '/../vendor/autoload.php';
    $app = require_once __DIR__ . '/../bootstrap/app.php';
    
    // Create a simple test response
    $response = $app->handle(
        \Illuminate\Http\Request::capture()
    );
    
    echo "<h1>Laravel Response Test</h1>";
    echo "Status Code: " . $response->getStatusCode() . "<br>";
    echo "Content: <br>";
    echo "<pre>" . htmlspecialchars($response->getContent()) . "</pre>";
    
} catch (Exception $e) {
    echo "<h1>Error</h1>";
    echo "Message: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
    echo "<pre>" . $e->getTraceAsString() . "</pre>";
}
?>