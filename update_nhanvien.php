<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "ql_nhansu");

// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Cập nhật thông tin nhân viên
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $ma_nv = $conn->real_escape_string($_POST['Ma_NV']);
    $ten_nv = $conn->real_escape_string($_POST['Ten_NV']);
    $phai = $conn->real_escape_string($_POST['Phai']);
    $noi_sinh = $conn->real_escape_string($_POST['Noi_Sinh']);
    $ma_phong = $conn->real_escape_string($_POST['Ma_Phong']);
    $luong = $conn->real_escape_string($_POST['Luong']);

    $sql = "UPDATE NHANVIEN SET Ten_NV='$ten_nv', Phai='$phai', Noi_Sinh='$noi_sinh', Ma_Phong='$ma_phong', Luong=$luong WHERE Ma_NV='$ma_nv'";

    if ($conn->query($sql) === TRUE) {
        echo "Cập nhật thông tin nhân viên thành công.";
        // Chuyển hướng người dùng về trang danh sách nhân viên
        header("Location: index.php");
    } else {
        echo "Error updating record: " . $conn->error;
    }
}

// Đóng kết nối
$conn->close();
?>
