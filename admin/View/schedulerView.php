<?php
    require_once '../Controller/scheduledController.php';
    
    $scheduledController = new ScheduledController();
    $timetable = $scheduledController->getAllTime();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Học cùng Nihongo | Lịch học</title>
    <link href="image/logoFaceWeb.png" rel="icon">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="css/styles.css">
</head>
<body>
    <?php require_once 'includes/sidebar.php'; ?>

    <section class="home">
        <section class="user-list scheduled">
            <?php require_once 'includes/adminView.php'; ?>

        <section class="wrapper">
            <div class="weeks">
                <ul class="week-list">
                    <li>
                        <button class="btn-week-choose" type="submit">1</button>
                    </li>
                    <li>
                        <button class="btn-week-choose" type="submit">2</button>
                    </li>
                    <li>
                        <button class="btn-week-choose" type="submit">3</button>
                    </li>
                    <li>
                        <button class="btn-week-choose" type="submit">4</button>
                    </li>
                </ul>
            </div>

            <div class="calendar">
                <div class="timetable">
                    <table>
                        <thead>
                            <tr>
                                <th class="time">Thời Gian</th>
                                <th>Thứ Hai</th>
                                <th>Thứ Ba</th>
                                <th>Thứ Tư</th>
                                <th>Thứ Năm</th>
                                <th>Thứ Sáu</th>
                                <th>Thứ Bảy</th>
                                <th>Chủ nhật</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                if ($timetable) {
                                    foreach ($timetable as $row) {
                                        echo '<tr data-id="' . htmlspecialchars($row['ID']) . '">';
                                            echo '<td>' . htmlspecialchars($row['GioBatDau']) . '<span class="separator">-</span>' . htmlspecialchars($row['GioKetThuc']) . '</td>';
                                        echo '</tr>';
                                    }
                                }                                
                                echo '</ul>';
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- <div class="calendar">
                <div class="calendar-header">
                    <button>&lt;</button>
                    <h2>May 2023</h2>
                    <button>&gt;</button>
                </div>
                <div class="calendar-grid">
                    <div class="day disabled">30</div>
                    <div class="day">1</div>
                    <div class="day">2</div>
                    <div class="day">3</div>
                    <div class="day">4</div>
                    <div class="day">5</div>
                    <div class="day">6</div>
                    <div class="day">7</div>
                    <div class="day selected">8</div>
                    <div class="day">9</div>
                    <div class="day">10</div>
                    <div class="day">11</div>
                    <div class="day">12</div>
                    <div class="day">13</div>
                    <div class="day">14</div>
                    <div class="day">15</div>
                    <div class="day">16</div>
                    <div class="day">17</div>
                    <div class="day selected">18</div>
                    <div class="day">19</div>
                    <div class="day">20</div>
                    <div class="day">21</div>
                    <div class="day">22</div>
                    <div class="day">23</div>
                    <div class="day">24</div>
                    <div class="day">25</div>
                    <div class="day">26</div>
                    <div class="day">27</div>
                    <div class="day">28</div>
                    <div class="day">29</div>
                    <div class="day">30</div>
                    <div class="day">31</div>
                    <div class="day disabled">1</div>
                    <div class="day disabled">2</div>
                    <div class="day disabled">3</div>
                </div>
            </div> -->
        </section>
    <script src="javascript/toggle.js"></script>
</body>
</html>