<?php
require '../connect.php';
// Lấy ID sản phẩm cần xóa
$id = $_GET['id'];

// Xóa sản phẩm
$sql = "DELETE FROM products WHERE id = $id";
if ($conn->query($sql)) {
    header("Location: index.php"); // Chuyển hướng về trang chính
} else {
    echo "Lỗi: " . $conn->error;
}

$conn->close();
?>