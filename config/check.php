<?php
/**
 * Cloud 9 Cafe - Configuration Check
 * Run this to verify your setup
 */

header('Content-Type: text/plain');

echo "=========================================\n";
echo "  CLOUD 9 CAFE - SETUP VERIFICATION\n";
echo "=========================================\n\n";

$errors = [];
$warnings = [];

// Check PHP version
echo "[1] Checking PHP Version...\n";
if (PHP_VERSION_ID >= 70400) {
    echo "    ✓ PHP " . PHP_VERSION . " (OK)\n";
} else {
    $errors[] = "PHP 7.4 or higher required";
    echo "    ✗ PHP " . PHP_VERSION . " (Too old)\n";
}

// Check .env file
echo "\n[2] Checking .env file...\n";
$envPath = __DIR__ . '/../.env';
if (file_exists($envPath)) {
    echo "    ✓ .env file exists\n";
} else {
    $errors[] = ".env file not found. Copy .env.example to .env";
    echo "    ✗ .env file NOT found\n";
}

// Check required extensions
echo "\n[3] Checking PHP Extensions...\n";
$required = ['mysqli', 'mbstring', 'gd'];
foreach ($required as $ext) {
    if (extension_loaded($ext)) {
        echo "    ✓ $ext loaded\n";
    } else {
        $warnings[] = "$ext extension not loaded";
        echo "    ⚠ $ext NOT loaded\n";
    }
}

// Check database connection
echo "\n[4] Checking Database Connection...\n";
try {
    require_once 'Env.php';
    $dbConfig = [
        'host' => Env::get('DB_HOST', 'localhost'),
        'user' => Env::get('DB_USERNAME', 'root'),
        'pass' => Env::get('DB_PASSWORD', ''),
        'name' => Env::get('DB_DATABASE', ''),
    ];
    
    $testCon = @mysqli_connect($dbConfig['host'], $dbConfig['user'], $dbConfig['pass']);
    if ($testCon) {
        echo "    ✓ Database connection successful\n";
        if (mysqli_select_db($testCon, $dbConfig['name'])) {
            echo "    ✓ Database '{$dbConfig['name']}' exists\n";
        } else {
            $warnings[] = "Database '{$dbConfig['name']}' not found";
            echo "    ⚠ Database '{$dbConfig['name']}' NOT found\n";
        }
        mysqli_close($testCon);
    } else {
        $errors[] = "Cannot connect to database: " . mysqli_connect_error();
        echo "    ✗ Database connection failed\n";
    }
} catch (Exception $e) {
    $errors[] = "Error checking database: " . $e->getMessage();
    echo "    ✗ Error: " . $e->getMessage() . "\n";
}

// Check folder permissions
echo "\n[5] Checking Folder Permissions...\n";
$folders = [
    'assets/uploads' => __DIR__ . '/../assets/uploads',
];
foreach ($folders as $name => $path) {
    if (is_writable($path)) {
        echo "    ✓ $name is writable\n";
    } else {
        $warnings[] = "$name is not writable";
        echo "    ⚠ $name is NOT writable\n";
    }
}

// Check session
echo "\n[6] Checking Session...\n";
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
echo "    ✓ Session working\n";

// Summary
echo "\n=========================================\n";
if (empty($errors) && empty($warnings)) {
    echo "  ✓ ALL CHECKS PASSED!\n";
    echo "  You can now use the application.\n";
} else {
    if (!empty($errors)) {
        echo "  ✗ ERRORS FOUND:\n";
        foreach ($errors as $error) {
            echo "    - $error\n";
        }
    }
    if (!empty($warnings)) {
        echo "  ⚠ WARNINGS:\n";
        foreach ($warnings as $warning) {
            echo "    - $warning\n";
        }
    }
}
echo "=========================================\n";

// Next steps
if (empty($errors)) {
    echo "\n📋 NEXT STEPS:\n";
    echo "1. Install database: http://localhost/cloud_9_cafe_rebuild/database/install_database.php\n";
    echo "2. Access website: http://localhost/cloud_9_cafe_rebuild/\n";
    echo "3. Login with: admin@cloud9cafe.com / admin123\n";
}
?>
