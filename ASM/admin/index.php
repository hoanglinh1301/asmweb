<?php
require '../connect.php';

// Lấy dữ liệu sản phẩm
$sql = "SELECT id, name, description, price, image FROM products";
$result = $conn->query($sql);

$products = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $products[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <style>
        .product-card {
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 16px;
            margin: 16px;
            width: 200px;
            text-align: center;
            display: inline-block;
        }
        .product-card img {
            max-width: 100%;
            height: auto;
        }
        .action-buttons {
            margin-top: 10px;
        }
        .action-buttons a {
            margin: 0 5px;
            text-decoration: none;
            color: white;
            padding: 5px 10px;
            border-radius: 3px;
        }
        .action-buttons .edit {
            background-color: #4CAF50;
        }
        .action-buttons .delete {
            background-color: #f44336;
        }
        .tabs {
            margin-bottom: 20px;
        }
        .tabs a {
            padding: 10px 15px;
            text-decoration: none;
            background-color: #ddd;
            margin-right: 5px;
        }
        .tabs a.active {
            background-color: #4CAF50;
            color: white;
        }
    </style>
</head>
<body>
    <div class="tabs">
        <a href="index.php" class="active">Quản lý sản phẩm</a>
        <a href="user.php">Quản lý người dùng</a>
    </div>
    
    <h1>Danh sách sản phẩm</h1>
    <a href="add_product.php" style="background-color: #4CAF50; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">Thêm sản phẩm mới</a>
    <div class="product-list">
        <?php foreach ($products as $product): ?>
            <div class="product-card">
                <img src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
                <h2><?php echo $product['name']; ?></h2>
                <p><?php echo $product['description']; ?></p>
                <p>Price: $<?php echo $product['price']; ?></p>
                <div class="action-buttons">
                    <a href="edit_product.php?id=<?php echo $product['id']; ?>" class="edit">Sửa</a>
                    <a href="delete_product.php?id=<?php echo $product['id']; ?>" class="delete" onclick="return confirm('Bạn có chắc chắn muốn xóa sản phẩm này?');">Xóa</a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>