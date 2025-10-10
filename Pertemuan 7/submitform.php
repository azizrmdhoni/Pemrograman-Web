<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
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
    
    $to = "muhamadaziz389@gmail.com";
    $subject = "Pesan Baru dari Contact Form - " . $name;
    
    $email_message = "
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
            .container { max-width: 600px; margin: 0 auto; padding: 20px; background-color: #f9f9f9; }
            .header { background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); color: white; padding: 20px; text-align: center; }
            .content { background: white; padding: 20px; margin-top: 20px; border-radius: 5px; }
            .field { margin-bottom: 15px; }
            .label { font-weight: bold; color: #667eea; }
            .footer { text-align: center; margin-top: 20px; font-size: 12px; color: #666; }
        </style>
    </head>
    <body>
        <div class='container'>
            <div class='header'>
                <h2>Pesan Baru dari Contact Form</h2>
            </div>
            <div class='content'>
                <div class='field'>
                    <span class='label'>Nama:</span><br>
                    " . $name . "
                </div>
                <div class='field'>
                    <span class='label'>Email:</span><br>
                    " . $email . "
                </div>
                <div class='field'>
                    <span class='label'>Pesan:</span><br>
                    " . nl2br($message) . "
                </div>
            </div>
            <div class='footer'>
                <p>Email ini dikirim dari formulir kontak website Anda</p>
            </div>
        </div>
    </body>
    </html>
    ";
    
    $headers = "MIME-Version: 1.0" . "\r\n";
    $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $headers .= "From: " . $name . " <" . $email . ">" . "\r\n";
    $headers .= "Reply-To: " . $email . "\r\n";
    
    $sent = mail($to, $subject, $email_message, $headers);
    
    if ($sent) {
        echo "<span style='color:green; font-weight:bold;'>✅ Terima kasih! Pesan Anda telah berhasil dikirim. Kami akan segera menghubungi Anda.</span>";
    } else {
        echo "<span style='color:red; font-weight:bold;'>❌ Maaf, terjadi kesalahan saat mengirim pesan. Silakan coba lagi.</span>";
    }
    
} else {
    echo "<span style='color:red; font-weight:bold;'>❌ Invalid request method!</span>";
}
?>
