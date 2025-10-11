<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $name = isset($_POST['name']) ? htmlspecialchars(trim($_POST['name'])) : '';
    $email = isset($_POST['email']) ? htmlspecialchars(trim($_POST['email'])) : '';
    $message = isset($_POST['message']) ? htmlspecialchars(trim($_POST['message'])) : '';

    if (empty($name) || empty($email) || empty($message)) {
        echo "<span style='color:red; font-weight:bold;'>❌ Semua field harus diisi!</span>";
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "<span style='color:red; font-weight:bold;'>❌ Format email tidak valid!</span>";
        exit;
    }

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'muhamadaziz389@gmail.com';
        $mail->Password   = '........'; // isi dengan password email yang sudah di generate di app pasword
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port       = 587;

        $mail->setFrom('muhamadaziz389@gmail.com', 'Website Contact Form');
        $mail->addAddress('muhamadaziz389@gmail.com', 'Admin');
        $mail->addReplyTo($email, $name);

        $mail->isHTML(true);
        $mail->Subject = "Pesan Baru dari $name";
        $mail->Body    = "<strong>Nama:</strong> $name<br><strong>Email:</strong> $email<br><strong>Pesan:</strong><br>" . nl2br($message);
        $mail->AltBody = "Nama: $name\nEmail: $email\nPesan:\n$message";

        $mail->send();
        echo "<span style='color:green; font-weight:bold;'>✅ Thank you for contacting us, we will get back to you shortly</span>";
    } catch (Exception $e) {
        echo "<span style='color:red; font-weight:bold;'>❌ Sorry! Your form submission is failed. Error: {$mail->ErrorInfo}</span>";
    }
} else {
    echo "<span style='color:red; font-weight:bold;'>❌ Invalid request method!</span>";
}
?>
