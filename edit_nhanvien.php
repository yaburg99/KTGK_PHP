<?php
// Kết nối cơ sở dữ liệu
$conn = new mysqli("localhost", "root", "", "ql_nhansu");
// Kiểm tra kết nối
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Lấy mã nhân viên từ URL
$ma_nv = isset($_GET['Ma_NV']) ? $_GET['Ma_NV'] : '';

// Lấy thông tin nhân viên từ cơ sở dữ liệu
$sql = "SELECT * FROM NHANVIEN WHERE Ma_NV = '$ma_nv'";
$result = $conn->query($sql);
$row = $result->num_rows > 0 ? $result->fetch_assoc() : null;

// Đóng kết nối
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Chỉnh Sửa Nhân Viên</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f0f2f5;
            margin: 0;
            padding: 20px;
        }
        .container {
            background-color: white;
            max-width: 600px;
            margin: 20px auto;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h2 {
            text-align: center;
            color: #333;
        }
        form {
            display: flex;
            flex-direction: column;
        }
        label {
            margin-bottom: 5px;
        }
        input[type="text"], input[type="number"], select {
            margin-bottom: 20px;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        input[type="submit"] {
            cursor: pointer;
            padding: 10px 20px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 4px;
            transition: background-color 0.3s ease;
        }
        input[type="submit"]:hover {
            background-color: #45a049;
        }
    </style>
<body>
    <?php if ($row): ?>
        <h2>Chỉnh Sửa Thông Tin Nhân Viên</h2>
        <form action="update_nhanvien.php" method="post">
            <input type="hidden" name="Ma_NV" value="<?php echo $row['Ma_NV']; ?>">
            Tên Nhân Viên: <input type="text" name="Ten_NV" value="<?php echo $row['Ten_NV']; ?>"><br>
            Giới Tính: <select name="Phai">
                <option value="Nam" <?php echo $row['Phai'] == 'Nam' ? 'selected' : ''; ?>>Nam</option>
                <option value="Nu" <?php echo $row['Phai'] == 'Nu' ? 'selected' : ''; ?>>Nữ</option>
            </select><br>
            Nơi Sinh: <input type="text" name="Noi_Sinh" value="<?php echo $row['Noi_Sinh']; ?>"><br>
            Tên Phòng: <input type="text" name="Ma_Phong" value="<?php echo $row['Ma_Phong']; ?>"><br>
            Lương: <input type="number" name="Luong" value="<?php echo $row['Luong']; ?>"><br>
            <input type="submit" value="Cập Nhật">
        </form>
    <?php else: ?>
        <p>Không tìm thấy thông tin nhân viên.</p>
    <?php endif; ?>
</body>
</html>

