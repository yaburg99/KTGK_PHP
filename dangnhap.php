<?php
session_start(); // Bắt đầu phiên làm việc

// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "ql_nhansu");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra dữ liệu đầu vào từ form đăng nhập
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $conn->real_escape_string($_POST['password']);

    // Truy vấn cơ sở dữ liệu để tìm người dùng
    $sql = "SELECT id, username, password, role FROM users WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) { // Giả sử bạn đã mã hóa mật khẩu
            // Đăng nhập thành công
            $_SESSION['loggedin'] = true;
            $_SESSION['username'] = $row['username'];
            $_SESSION['role'] = $row['role'];
            $_SESSION['user_id'] = $row['id'];

            // Chuyển hướng người dùng dựa trên vai trò
            if ($row['role'] == 'admin') {
                header("Location: index.php");
            } else {
                header("Location: indexuser.php");
            }
            exit;
        } else {
            // Sai mật khẩu
            echo "Invalid password!";
        }
    } else {
        // Không tìm thấy username
        echo "<script>alert('Sai ! Hãy đăng ký tại trang đăng ký. Bạn sẽ được chuyển đến trang đăng ký.'); window.location.href='register.html';</script>";
    }
}
$conn->close();
?>