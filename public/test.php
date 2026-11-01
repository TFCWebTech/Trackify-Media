<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Debug Information</h1>";

// Check PHP version
echo "PHP Version: " . phpversion() . "<br>";

// Check DOM extension
if (class_exists('DOMDocument')) {
    echo "✓ DOMDocument is available<br>";
} else {
    echo "✗ DOMDocument is NOT available<br>";
}

// Check if we can load Laravel
echo "<br>Attempting to load Laravel...<br>";
try {
    require __DIR__ . '/../vendor/autoload.php';
    echo "✓ Autoloader loaded<br>";
    
    require __DIR__ . '/../bootstrap/app.php';
    echo "✓ Bootstrap loaded<br>";
    
    echo "✓ Laravel files loaded successfully<br>";
} catch (Exception $e) {
    echo "✗ Error: " . $e->getMessage() . "<br>";
    echo "File: " . $e->getFile() . "<br>";
    echo "Line: " . $e->getLine() . "<br>";
}

// Check file permissions
echo "<br>File Permissions:<br>";
$files = [
    __DIR__ . '/index.php',
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../bootstrap/app.php',
    __DIR__ . '/../storage',
    __DIR__ . '/../.env'
];

foreach ($files as $file) {
    if (file_exists($file)) {
        echo "✓ " . basename($file) . " exists (";
        echo decoct(fileperms($file) & 0777) . ")<br>";
    } else {
        echo "✗ " . basename($file) . " MISSING<br>";
    }
}
?>