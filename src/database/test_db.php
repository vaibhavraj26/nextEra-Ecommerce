<?php
require_once 'Database.php';

try {
    $db = Database::getInstance();
    echo "Database connection successful!";
} catch (PDOException $e) {
    echo "Database connection failed: " . $e->getMessage();
}
?>