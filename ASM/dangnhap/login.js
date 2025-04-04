document.getElementById('login-form').addEventListener('submit', function (e) {
    e.preventDefault();

    // Lấy giá trị từ form
    const username = document.getElementById('username').value.trim(); // Sửa ID từ 'full_name' thành 'username'
    const password = document.getElementById('password').value.trim();

    // Kiểm tra các trường không được để trống
    if (username === "" || password === "") {
        alert("Vui lòng điền đầy đủ tên đăng nhập và mật khẩu.");
        return;
    }

    // Lấy thông tin người dùng từ localStorage
    const userData = JSON.parse(localStorage.getItem(username)); // Lấy dữ liệu dựa trên username làm key

    // Kiểm tra thông tin đăng nhập
    if (userData && userData.password === password) {
        alert("Login successful");
        // Lưu thông tin user đang đăng nhập
        localStorage.setItem('currentUser', JSON.stringify({ username: username }));
        window.location.href = "../home/trangchu.html";
    } else {
        alert("Wrong account or password");
    }
});