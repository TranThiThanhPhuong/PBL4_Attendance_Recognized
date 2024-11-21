<?php
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'phpMailer/PHPMailer-master/src/Exception.php';
    require 'phpMailer/PHPMailer-master/src/PHPMailer.php';
    require 'phpMailer/PHPMailer-master/src/SMTP.php';
    require_once '../ConnDB/connDB.php';
    require_once '../Controller/studentsController.php';
    $studentsController = new StudentsController($connectionDB);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $studentsPresent = json_decode($_POST['studentsPresent']);
        $studentsAbsent = json_decode($_POST['studentsAbsent']);

        try {
            $mail = new PHPMailer(true);
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'phuongsuga333@gmail.com'; 
            $mail->Password = 'jhow mqds wyyt ykgq'; 
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;
            $mail->setFrom('phuongsuga333@gmail.com', 'Admin'); 
            
            foreach ($studentsPresent as $student) {
                $studentInfo = $studentsController->getInfoStudent($student->ID);
                if ($studentInfo && isset($studentInfo['email'])) {
                    $mail->addAddress($studentInfo['email']); 
                    $mail->Subject = 'Điểm danh - Học cùng Nihongo';
                    $mail->Body    = 'Chào ' . $studentInfo['Ten'] . ',\n\nBạn đã được điểm danh là có mặt trong lớp hôm nay.';
                    $mail->send();
                    $mail->clearAddresses(); 
                }
            }

            foreach ($studentsAbsent as $student) {
                $studentInfo = $studentsController->getInfoStudent($student->ID);
                if ($studentInfo && isset($studentInfo['email'])) {
                    $mail->addAddress($studentInfo['email']); 
                    $mail->Subject = 'Điểm danh - Học cùng Nihongo';
                    $mail->Body    = 'Chào ' . $studentInfo['Ten'] . ',\n\nBạn đã bị điểm danh vắng trong lớp hôm nay.';
                    $mail->send();
                    $mail->clearAddresses(); 
                }
            }

            echo "<script>
                    alert('Email đã được gửi thành công!');
                    window.location.href = 'attendanceView.php';
                </script>";
            exit();
        } catch (Exception $e) {
            echo "Lỗi khi gửi email: {$mail->ErrorInfo}";
        }
    }
?>
