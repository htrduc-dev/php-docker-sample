<?php

$host = 'db';          // tên service trong docker-compose
$db   = 'app';
$user = 'app';
$pass = 'app';
$charset = 'utf8mb4';

$dsn = "mysql:host=$host;dbname=$db;port=3306;charset=$charset";

$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // bật exception khi lỗi
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES   => false,
];

try {
    $pdo = new PDO($dsn, $user, $pass, $options);

    echo "<h1>Kết nối MySQL thành công!</h1>";

    // Tạo bảng test nếu chưa có
    $pdo->exec("
        CREATE TABLE IF NOT EXISTS demo_test (
            id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
            message VARCHAR(255) NOT NULL
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;
    ");

    // Chèn 1 dòng dữ liệu mẫu
    $stmt = $pdo->prepare("INSERT INTO demo_test (message) VALUES (:msg)");
    $stmt->execute(['msg' => 'Xin chào từ Docker + MySQL!']);

    // Lấy dữ liệu ra
    $rows = $pdo->query("SELECT * FROM demo_test ORDER BY id DESC LIMIT 5")->fetchAll();

    echo "<pre>";
    print_r($rows);
    echo "</pre>";

} catch (PDOException $e) {
    echo "<h1>Lỗi kết nối MySQL</h1>";
    echo "<p>" . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8') . "</p>";
}
