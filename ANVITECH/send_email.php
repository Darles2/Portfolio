<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

$mail = new PHPMailer(true);

try {
    // Server settings
    $mail->isSMTP();
    $mail->Host       = 'smtp.mailtrap.io'; 
    $mail->SMTPAuth   = true;
    $mail->Username   = ''; 
    $mail->Password   = ''; 
    $mail->SMTPSecure = 'tls';
    $mail->Port       = 587;

    // Recipients
    $mail->setFrom('no-reply@anvitech.ua', 'Anvitech Website');
    $mail->addAddress('info@anvitech.ua', 'Anvitech');

    // Attach file if uploaded
    if (isset($_FILES['upload-img']) && $_FILES['upload-img']['error'] == UPLOAD_ERR_OK) {
        $mail->addAttachment($_FILES['upload-img']['tmp_name'], $_FILES['upload-img']['name']);
    }

    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Нове повідомлення з сайту';
    $mail->Body = "
        <strong>Ім’я:</strong> {$_POST['name']}<br>
        <strong>Місто:</strong> {$_POST['city']}<br>
        <strong>Email:</strong> {$_POST['email']}<br>
        <strong>Телефон:</strong> {$_POST['phone']}<br>
        <strong>Повідомлення:</strong><br>{$_POST['message']}
    ";

    $mail->send();
    echo "✅ Повідомлення успішно надіслано.";
} catch (Exception $e) {
    echo "❌ Помилка: {$mail->ErrorInfo}";
}
