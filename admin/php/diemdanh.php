<?php
require_once 'database/connDB.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học cùng Nihongo | Học viên</title>
    <link href="../image/logoFaceWeb.png" rel="icon">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="../css/styles.css">
</head>
<body>
    <?php require_once 'includes/sidebar.php'; ?>
    
    <section class="home">
        <section class="user-list">
            <?php require_once 'includes/user.php'; ?>

            <div class="main-card">
                <div class="main-skills">
                    <?php
                    for ($i = 1; $i <= 5; $i++) {
                        $query = "SELECT TenCapDo FROM capdo WHERE ID = $i";
                        $connection = $conn->query($query);
                        $result = $connection->fetch_assoc();
                        $tenCapDo = $result['TenCapDo'];
                        echo '
                            <div class="card other">
                                <div class="detail">
                                    <h3 id="N' . $i . '">' . htmlspecialchars($tenCapDo) . '</h3>
                                </div>
                                <form class="capDoForm" method="POST" action="">
                                    <input type="hidden" name="capDo" value="' . htmlspecialchars($tenCapDo) . '">
                                    <button type="submit" class="btnView">View</button>
                                </form>
                            </div>';
                    }
                    ?>
                </div>
            </div>

            <div class="attendance-list" style="<?php echo isset($_POST['capDo']) ? 'display: block;' : 'display: none;'; ?>">
                <h1>Danh sách tất cả các học viên</h1>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Ngày sinh</th>
                            <th>Lớp</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            if (isset($_POST['capDo'])) {
                                $capDo = $conn->real_escape_string($_POST['capDo']);
                                $query = "
                                    SELECT hv.ID, hv.Ten, hv.NgaySinh, lop.TenLop
                                    FROM hocvien AS hv
                                    JOIN lop ON hv.ID_Lop = lop.ID
                                    JOIN capdo ON hv.ID_CapDo = capdo.ID
                                    WHERE capdo.TenCapDo = '$capDo';
                                ";
                                $connection = $conn->query($query);
                                if ($connection->num_rows > 0) {
                                    while ($row = $connection->fetch_assoc()) {
                                        echo '<tr>';
                                        echo '<td>' . htmlspecialchars($row['ID']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['Ten']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['NgaySinh']) . '</td>';
                                        echo '<td>' . htmlspecialchars($row['TenLop']) . '</td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="4">Không có học sinh cấp độ này.</td></tr>';
                                }
                            }
                        ?>
                    </tbody>
                </table>
                <button class="btnThoat">Thoát</button>
            </div>

        </section>
    </section>

    <script src="../javascript/toggle.js"></script>
    <script>
        const attendanceList = document.querySelector(".attendance-list");
        const mainCard = document.querySelector(".main-card"); 
        const btnThoat = document.querySelector(".btnThoat");

        btnThoat.addEventListener("click", () => {
            attendanceList.style.display = "none";
            mainCard.style.display = "block";
            document.querySelectorAll(".capDoForm").forEach(form => form.reset());
        });
    </script>

</body>
</html>
