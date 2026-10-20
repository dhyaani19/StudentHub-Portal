<?php
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
try {
    $conn = new mysqli("localhost", "root", "");
    $conn->set_charset("utf8mb4");
    $conn->query("CREATE DATABASE IF NOT EXISTS studenthub CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $conn->select_db("studenthub");
} catch (mysqli_sql_exception $e) {
    http_response_code(500);
    exit("Database connection failed. Start MySQL in XAMPP and check the credentials in db.php. Details: " . htmlspecialchars($e->getMessage()));
}
