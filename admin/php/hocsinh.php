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
            
            <div id="overlay"></div>

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
                                    <button idcapdo="' . htmlspecialchars($i) . '" type="submit" class="btnView">View</button>
                                </form>
                            </div>';
                    }
                    ?>
                </div>
            </div>

            <div class="attendance-list" style="<?php echo isset($_POST['capDo']) ? 'display: block;' : 'display: none;'; ?>">
                <div class="title">
                    <h1>Danh sách tất cả các học viên</h1>
                    <button class="btnNew"><i class="las la-plus-circle"></i>New</button>
                </div>
                <table class="table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Họ và tên</th>
                            <th>Ngày sinh</th>
                            <th>Lớp</th>
                            <th>Thao tác</th>
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
                                        echo '<tr data-id="' . htmlspecialchars($row['ID']) . '">';
                                            echo '<td>' . htmlspecialchars($row['ID']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['Ten']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['NgaySinh']) . '</td>';
                                            echo '<td>' . htmlspecialchars($row['TenLop']) . '</td>';
                                            echo '<td>
                                                    <button class="btninfo btnicon" data-idxembtn="' . htmlspecialchars($row['ID']) . '"><i class="las la-info"></i></button>
                                                    <button class="btnedit btnicon" data-idsuabtn="' . htmlspecialchars($row['ID']) . '"><i class="las la-edit"></i></button>
                                                    <button class="btntrash btnicon" data-idxoabtn="' . htmlspecialchars($row['ID']) . '"><i class="las la-trash"></i></button>
                                                  </td>';
                                        echo '</tr>';
                                    }
                                } else {
                                    echo '<tr><td colspan="4">Không có học sinh cấp độ này.</td></tr>';
                                }
                            }
                        ?>
                    </tbody>
                </table>
            </div>

            <!-- ====XEM THONG TIN HOC VIEN==== -->
            <section id="xemthongtin" class="xemthongtin" style="display: none;">
                <div class="header-info">
                    <h3>Profile</h3>
                    <button class="btnClose"><i class="las la-times"></i></button>
                </div>
                <form class="main-info">
                    <div class="img-face">
                        <img src="" alt="">
                    </div>
                    <div class="text-info">
                            <div>
                                <label for="idxem">ID:</label>
                                <input type="text" name="" id="idxem" disabled>
                            </div>
                            <div>
                                <label for="tenxem">Họ và tên:</label>
                                <input type="text" name="" id="tenxem" disabled>
                            </div>
                            <div class="gender">
                                <label for="gendersua">Giới tính:</label>
                                <div class="gender-detail">
                                    <input disabled type="radio" name="gender" id="genderxemnu" value="Nu">Nữ
                                    <input disabled type="radio" name="gender" id="genderxemnam" value="Nam">Nam
                                </div>
                            </div>
                            <div>
                                <label for="datexem">Ngày sinh:</label>
                                <input type="date" name="" id="datexem" disabled>
                            </div>
                            <div>
                                <label for="emailxem">E-mail:</label>
                                <input type="email" name="" id="emailxem" disabled>
                            </div>
                            <div>
                                <label for="diachixem">Địa chỉ</label>
                                <input type="text" name="" id="diachixem" disabled>
                            </div>
                    </div>
                </form>
            </section>  
            
            <!-- ====SUA THONG TIN HOC VIEN==== -->
            <section id="suathongtin" class="suathongtin" style="display: none;">
                <div class="header-info">
                    <h3>Profile</h3>
                    <div>
                        <button class="btnClose1"><i class="las la-times"></i></button>
                    </div>
                </div>
                <form class="main-info" id="editForm" method="POST" action="../controllers/updateInfoHV.php">
                    <div class="img-face">
                        <img src="" alt="">
                    </div>
                    <div class="text-info">
                        <div>
                            <label for="idsua">ID:</label>
                            <input type="text" name="id" id="idsua" disabled>
                        </div>
                        <div>
                            <label for="tensua">Họ và tên:</label>
                            <input type="text" name="ten" id="tensua">
                        </div>
                        <div class="gender">
                            <label for="gendersua">Giới tính:</label>
                            <div class="gender-detail">
                                <input type="radio" name="gender" id="gendersuanu" value="Nu"> Nữ
                                <input type="radio" name="gender" id="gendersuanam" value="Nam"> Nam
                            </div>
                        </div>
                        <div>
                            <label for="datesua">Ngày sinh:</label>
                            <input type="date" name="date" id="datesua">
                        </div>
                        <div>
                            <label for="emailsua">E-mail:</label>
                            <input type="email" name="email" id="emailsua">
                        </div>
                        <div>
                            <label for="diachisua">Địa chỉ</label>
                            <input type="text" name="address" id="diachisua">
                        </div>
                        <button class="btnUpdate" type="submit">Update</button>
                    </div>
                </form>

            </section>  
            
            <!-- ====THEM HOC VIEN==== -->
            <section class="themhocvien" style="display: none;">
                <div class="header-info">
                    <h3>Profile</h3>
                    <div>
                        <button class="btnClose2"><i class="las la-times"></i></button>
                    </div>
                </div>
                <form class="main-info">
                    <div class="img-face">
                        <a href=""><i class="las la-upload"></i>Import <br> picture</a>
                    </div>
                    <div class="text-info">
                        <div>
                            <label for="idthem">ID:</label>
                            <input type="text" name="" id="idthem">
                        </div>
                        <div>
                            <label for="tenthem">Họ và tên:</label>
                            <input type="text" name="" id="tenthem">
                        </div>
                        <div class="gender">
                            <label for="genderthem">Giới tính:</label>
                            <div class="gender-detail">
                                <input type="radio" name="gender" id="genderthemnu" value="Nu">Nữ
                                <input type="radio" name="gender" id="genderthemnam" value="Nam">Nam
                            </div>
                        </div>
                        <div>
                            <label for="datethem">Ngày sinh:</label>
                            <input type="date" name="" id="datethem">
                        </div>
                        <div>
                            <label for="emailthem">E-mail:</label>
                            <input type="email" name="" id="emailthem">
                        </div>
                        <div>
                            <label for="diachithem">Địa chỉ</label>
                            <input type="text" name="" id="diachithem">
                        </div>
                        <div class="capdo">
                            <label for="diachithem">Cấp độ</label>
                            <?php
                                echo '
                                    <select name="capdo" id="capdo" class="select-capdo" onchange="selectLop()">
                                        <option value="" disabled selected hidden>Chọn cấp độ</option>';
                                        for ($i = 1; $i <= 5; $i++) {
                                            $query = "SELECT TenCapDo FROM capdo WHERE ID = $i";
                                            $connection = $conn->query($query);
                                            $result = $connection->fetch_assoc();
                                            $tenCapDo = $result['TenCapDo'];

                                            echo '
                                                <option data-idcapdo=' . $i . ' value="N' . $i . '">' . htmlspecialchars($tenCapDo) . '</option>    
                                            ';
                                        }
                                echo '
                                    </select>
                                ';
                            ?>
                            <label for="diachithem">Lớp</label>
                            <select name="lop" id="lop" class="select-lop" >
                                <option value="" disabled selected hidden>Chọn lớp</option>
                            </select>
                        </div>
                        <button class="btnSave">Lưu</button>
                    </div>
                </form>
            </section>  

            <div id="confirmBox" class="confirm-box hidden">
                <div class="confirm-content">
                    <p>Bạn có chắc chắn muốn xóa không?</p>
                    <div class="confirm-buttons">
                        <button id="btnYes">Có</button>
                        <button id="btnNo">Không</button>
                    </div>
                </div>
            </div>

        </section>
    </section>


    <script src="../javascript/toggle.js"></script>
    <script src="../javascript/hocsinh.js"></script>

</body>
</html>
