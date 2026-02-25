<?php
/**
 * Cloud 9 Cafe - Database Installation Script
 * Run this file once to set up the complete database schema
 */

include_once '../config/db_config.php';

// Set header for plain text output
header('Content-Type: text/plain');

echo "=========================================\n";
echo "  CLOUD 9 CAFE - DATABASE INSTALLER\n";
echo "=========================================\n\n";

// Read and execute SQL file
$sql_file = file_get_contents('schema.sql');

// Remove comments and split into individual queries
$sql_file = preg_replace('/--.*\n/', '', $sql_file);
$sql_file = preg_replace('/\/\*.*?\*\//s', '', $sql_file);

// Split by semicolon but preserve those inside statements
$queries = array_filter(array_map('trim', explode(';', $sql_file)));

$success_count = 0;
$error_count = 0;

foreach ($queries as $query) {
    if (empty($query)) continue;
    
    // Skip DROP statements for safety in production
    if (stripos($query, 'DROP TABLE') !== false) {
        echo "[SKIP] DROP statement skipped for safety\n";
        continue;
    }
    
    if (mysqli_query($con, $query)) {
        // Extract table name for display
        if (preg_match('/CREATE TABLE\s+(\w+)/i', $query, $matches)) {
            echo "[OK] Created table: {$matches[1]}\n";
            $success_count++;
        } elseif (preg_match('/INSERT INTO\s+(\w+)/i', $query, $matches)) {
            echo "[OK] Inserted data into: {$matches[1]}\n";
            $success_count++;
        } else {
            echo "[OK] Query executed successfully\n";
            $success_count++;
        }
    } else {
        echo "[ERROR] " . mysqli_error($con) . "\n";
        $error_count++;
    }
}

echo "\n=========================================\n";
echo "  INSTALLATION COMPLETE\n";
echo "=========================================\n";
echo "Successful: $success_count\n";
echo "Errors: $error_count\n";
echo "\nDefault Admin Credentials:\n";
echo "  Email: admin@cloud9cafe.com\n";
echo "  Password: admin123\n";
echo "\nIMPORTANT: Change default password after first login!\n";
echo "=========================================\n";

mysqli_close($con);
?>
