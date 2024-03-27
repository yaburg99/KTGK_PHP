<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "ql_nhansu");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Kiểm tra dữ liệu gửi từ form
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($conn->real_escape_string($_POST['password']), PASSWORD_DEFAULT);
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $role = 'user'; // Mặc định tất cả người dùng mới là 'user'

    // Kiểm tra xem tên người dùng đã tồn tại hay chưa
    $sql = "SELECT id FROM users WHERE username = '$username'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        echo "Username already exists!";
    } else {
        // Chèn dữ liệu người dùng mới vào cơ sở dữ liệu
        $sql = "INSERT INTO users (username, password, fullname, email, role) VALUES ('$username', '$password', '$fullname', '$email', '$role')";

        if ($conn->query($sql) === TRUE) {
            echo "<script>alert('Đăng ký thành công. Bạn sẽ được chuyển đến trang đăng nhập.'); window.location.href='login.html';</script>";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}
$conn->close();
?>
