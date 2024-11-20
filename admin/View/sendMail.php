<?php

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;
    require 'phpMailer/PHPMailer-master/src/Exception.php';
    require 'phpMailer/PHPMailer-master/src/PHPMailer.php';
    require 'phpMailer/PHPMailer-master/src/SMTP.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);

    $mail = new PHPMailer(true);

    try {
        // Cấu hình SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'phuongsuga333@gmail.com'; 
        $mail->Password = 'jhow mqds wyyt ykgq'; 
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->setFrom('phuongsuga333@gmail.com', 'Admin');

        // Gửi email cho học sinh có mặt
        if (!empty($data['present'])) {
            foreach ($data['present'] as $student) {
                $email = $student['email'];
                $message = $student['message'];

                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Thông báo: Học sinh có mặt';
                $mail->Body = nl2br($message);
                $mail->send();
                $mail->clearAddresses(); // Xóa danh sách email
            }
        }

        // Gửi email cho học sinh vắng mặt
        if (!empty($data['absent'])) {
            foreach ($data['absent'] as $student) {
                $email = $student['email'];
                $message = $student['message'];

                $mail->addAddress($email);
                $mail->isHTML(true);
                $mail->Subject = 'Thông báo: Học sinh vắng mặt';
                $mail->Body = nl2br($message);
                $mail->send();
                $mail->clearAddresses(); // Xóa danh sách email
            }
        }

        echo "Email đã được gửi thành công!";
    } catch (Exception $e) {
        echo "Lỗi khi gửi email: {$mail->ErrorInfo}";
    }
    }
?>
