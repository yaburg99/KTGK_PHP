<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách nhân viên</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }
        table, th, td {
            border: 1px solid black;
            padding: 8px;
            text-align: left;
        }
        .pagination {
            display: inline-block;
            margin-top: 20px;
        }
        .pagination a {
            color: black;
            float: left;
            padding: 8px 16px;
            text-decoration: none;
            transition: background-color .3s;
            border: 1px solid #ddd;
            margin: 0 4px;
        }
        .pagination a.active {
            background-color: #4CAF50;
            color: white;
            border: 1px solid #4CAF50;
        }
        .pagination a:hover:not(.active) {background-color: #ddd;}
        .edit-btn, .delete-btn {
            padding: 5px 10px;
            margin-right: 5px;
            border-radius: 5px;
            text-decoration: none;
            color: white;
        }
        .edit-btn { background-color: #f0ad4e; }
        .delete-btn { background-color: #d9534f; }
    </style>
</head>
<body>

<h1>THÔNG TIN NHÂN VIÊN</h1>

<table>
    <tr>
        <th>Mã Nhân Viên</th>
        <th>Tên Nhân Viên</th>
        <th>Giới Tính</th>
        <th>Nơi Sinh</th>
        <th>Tên Phòng</th>
        <th>Lương</th>
    </tr>
    <?php
    // Chèn mã PHP vào đây
    // Kết nối đến cơ sở dữ liệu
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "ql_nhansu";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Kết nối thất bại: " . $conn->connect_error);
    }

    $sql = "SELECT * FROM NHANVIEN";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo "<tr>";
            echo "<td>".$row["Ma_NV"]."</td>";
            echo "<td>".$row["Ten_NV"]."</td>";
            echo "<td><img src='".($row["Phai"] == "NU" ? "man.png" : "women.jpg")."' alt='Gender' style='width:20px;height:20px;'></td>";
            echo "<td>".$row["Noi_Sinh"]."</td>";
            echo "<td>".$row["Ma_Phong"]."</td>";
            echo "<td>".$row["Luong"]."</td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Không có nhân viên nào.</td></tr>";
    }

    $conn->close();
    ?>
</table>
</body>
</html>
