document.getElementById('register-form').addEventListener('submit', function (event) {
    event.preventDefault();

    // Lấy giá trị từ form
    const username = document.getElementById('username').value;
    const password = document.getElementById('password').value;
    const phone = document.getElementById('phone').value;
    const address = document.getElementById('address').value;

    // Kiểm tra dữ liệu
    if (!username || !password || !phone || !address) {
        alert('Vui lòng điền đầy đủ thông tin');
        return;
    }

    // Tạo object user
    const user = {
        full_name: username,
        password: password,
        phone: phone,
        address: address
    };

    // Lưu vào localStorage (sử dụng username làm key)
    localStorage.setItem(username, JSON.stringify(user));

    alert('Đăng ký thành công!');
    window.location.href = "../dangnhap/Login.html";
});