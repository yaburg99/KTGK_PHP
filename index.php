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
        .add-nhanvien-btn {
        display: inline-block;
        background-color: #4CAF50; /* Màu nền của nút */
        color: white; /* Màu chữ */
        text-align: center;
        padding: 10px 20px; /* Khoảng cách trên và dưới 10px, trái và phải 20px */
        text-decoration: none; /* Loại bỏ gạch chân của liên kết */
        font-size: 16px; /* Kích thước font */
        margin: 10px 0; /* Khoảng cách trên và dưới 10px */
        cursor: pointer; /* Biểu tượng con trỏ khi di qua nút */
        border-radius: 5px; /* Bo góc của nút */
        border: none; /* Loại bỏ viền của button */
        }

        .add-employee-btn:hover {
            background-color: #45a049; /* Màu nền khi hover */
        }
    </style>
</head>
<body>

<h1>THÔNG TIN NHÂN VIÊN</h1>
<a href="addnhanvien.html" class="add-nhanvien-btn">Thêm Nhân Viên</a>
<table>
    <tr>
        <th>Mã Nhân Viên</th>
        <th>Tên Nhân Viên</th>
        <th>Giới Tính</th>
        <th>Nơi Sinh</th>
        <th>Tên Phòng</th>
        <th>Lương</th>
        <th>Hành Động</th>
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
    $results_per_page = 5; // Số lượng nhân viên trên mỗi trang
    $sql = "SELECT COUNT(Ma_NV) AS total FROM NHANVIEN";
    $result = $conn->query($sql);
    $row = $result->fetch_assoc();
    $number_of_results = $row['total'];
    $number_of_pages = ceil($number_of_results / $results_per_page);
    if (!isset($_GET['page'])) {
        $page = 1;
    } else {
        $page = $_GET['page'];
    }
    $this_page_first_result = ($page - 1) * $results_per_page;
    $sql = "SELECT * FROM NHANVIEN LIMIT " . $this_page_first_result . ',' . $results_per_page;
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
            echo "<td><a href='edit_nhanvien.php?Ma_NV=".$row["Ma_NV"]."' class='edit-btn'><i class='fas fa-edit'></i></a>";
            echo "<a href='delete_nhanvien.php?Ma_NV=".$row["Ma_NV"]."' class='delete-btn' onclick='return confirm(\"Bạn có chắc chắn muốn xóa nhân viên này không?\");'><i class='fas fa-trash-alt'></i></a></td>";
            echo "</tr>";
        }
    } else {
        echo "<tr><td colspan='7'>Không có nhân viên nào.</td></tr>";
    }

    $conn->close();
    
    ?>
    <div class="pagination">
    <?php
    for ($page = 1; $page <= $number_of_pages; $page++) {
        echo '<a href="index.php?page=' . $page . '">' . $page . '</a> ';
    }
    ?>
</div>
</table>
</body>
</html>
