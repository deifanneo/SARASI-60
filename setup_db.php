<?php
$host = 'localhost';
$username = 'root';
$password = ''; // Default Laragon

try {
    // Connect without DB
    $conn = new PDO("mysql:host=$host", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    echo "Connected to MySQL server.\n";

    // Create DB
    $conn->exec("CREATE DATABASE IF NOT EXISTS sarasi_db");
    echo "Database 'sarasi_db' created or already exists.\n";

    // Select DB
    $conn->exec("USE sarasi_db");

    // Read SQL file
    $sql = file_get_contents('database.sql');
    
    // Execute SQL
    // We need to split by semicolon if we were raw, but PDO::exec might handle multiple statements if supported.
    // However, robust way is to run queries one by one or ensure the driver supports options.
    // Let's try simple exec first. If it fails on multiple, we split.
    // Actually, loading the entire file might be tricky with multiple statements in one exec call in some configs.
    // Let's try to pass it all.
    
    $conn->exec($sql);
    echo "Tables and data imported successfully.\n";

} catch(PDOException $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
