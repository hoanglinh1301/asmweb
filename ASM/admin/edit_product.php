<?php
require '../connect.php';

// Lấy thông tin sản phẩm cần chỉnh sửa
$id = $_GET['id'];
$sql = "SELECT * FROM products WHERE id = $id";
$result = $conn->query($sql);
$product = $result->fetch_assoc();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Lấy dữ liệu từ form
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $image = $_POST['image'];

    // Cập nhật sản phẩm
    $sql = "UPDATE products SET name='$name', description='$description', price=$price, image='$image' WHERE id=$id";
    if ($conn->query($sql)) {
        header("Location: index.php"); // Chuyển hướng về trang chính
    } else {
        echo "Lỗi: " . $conn->error;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sửa sản phẩm</title>
</head>
<body>
    <h1>Sửa sản phẩm</h1>
    <form method="POST" action="">
        <label for="name">Tên sản phẩm:</label>
        <input type="text" id="name" name="name" value="<?php echo $product['name']; ?>" required><br><br>
        <label for="description">Mô tả:</label>
        <textarea id="description" name="description" required><?php echo $product['description']; ?></textarea><br><br>
        <label for="price">Giá:</label>
        <input type="number" id="price" name="price" step="0.01" value="<?php echo $product['price']; ?>" required><br><br>
        <label for="image">Đường dẫn hình ảnh:</label>
        <input type="text" id="image" name="image" value="<?php echo $product['image']; ?>" required><br><br>
        <button type="submit">Lưu thay đổi</button>
    </form>
    <a href="index.php">Quay lại</a>
</body>
</html>