<?php

require '../connect.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = trim($_POST["full_name"]);
    $password = trim($_POST["password"]);
    $phone = trim($_POST["phone"]);
    $address = trim($_POST["address"]);

    // ma hoa pass
    $hashed_password = Password_hash($password, PASSWORD_DEFAULT);

    // $conn = new mysqli("localhost", "username", "password", "database_name");

    $sql = "INSERT INTO users (user_name, password, phone , address) VALUES (?,?,?,?)";
    $stmt = mysqli_prepare($conn ,$sql);

    if($stmt) {
        mysqli_stmt_bind_param($stmt, "ssis", $username , $hashed_password, $phone, $address);
        if (mysqli_stmt_execute($stmt)) {
            echo "Success!";
            header("Location: ../dangnhap/Login.html");
            exit();
        }
        else {
            echo "ket noi khong thanh cong" . mysql_connect_error();
        }
    mysqli_stmt_close($stmt);
    }
    else{
        echo "ket noi khong thanh cong 123". mysql_connect_error();
    }
}
mysqli_close($conn);
