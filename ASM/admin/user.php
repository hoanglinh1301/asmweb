<?php
require '../connect.php';

// Get user data
$sql = "SELECT user_name, phone, address FROM users";
$result = $conn->query($sql);

$users = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $users[] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
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
        <a href="index.php">Product Management</a>
        <a href="users.php" class="active">User Management</a>
    </div>
    
    <h1>User List</h1>
    <a href="add_user.php" style="background-color: #4CAF50; color: white; padding: 10px 15px; text-decoration: none; border-radius: 5px;">Add New User</a>
    <table>
        <thead>
            <tr>
                <th>Username</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?php echo htmlspecialchars($user['user_name']); ?></td>
                    <td><?php echo htmlspecialchars($user['phone']); ?></td>
                    <td><?php echo htmlspecialchars($user['address']); ?></td>
                    <td class="action-buttons">
                        <a href="edit_user.php?user_name=<?php echo urlencode($user['user_name']); ?>" class="edit">Edit</a>
                        <a href="delete_user.php?user_name=<?php echo urlencode($user['user_name']); ?>" class="delete" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>