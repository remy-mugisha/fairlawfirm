<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

if (isset($_POST['submit'])) {
    require 'composer/vendor/autoload.php';
    $mail = new PHPMailer(true);
    // $mail->SMTPDebug = SMTP::DEBUG_SERVER;    
    $mail->isSMTP();
    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;
    $mail->addCC('remymugisha64@gmail.com');
    $mail->Username = 'remymugisha64@gmail.com';
    $mail->Password = 'mtujlsquuhmruxwu';
    $mail->SMTPSecure = 'TLS';
    $mail->Port = 587;
    $mail->setFrom('remymugisha64@gmail.com');
    $mail->addAddress($_POST["email"]);
    $mail->isHTML(true);
    $mail->Subject = 'Fair Law Firm LTD';

    $guests = $_POST['guests'];
    $phone = $_POST['phone'];
    $comments = $_POST['comments'];
    $name = $_POST['name'];
    $email = $_POST['email'];
    $title = $_POST['title'];

    $mail->Body = "
    <!DOCTYPE html>
<html lang='en'>
<head>
    <meta charset='UTF-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
    <title>Congratulations Email</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #e8efef;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .email-container {
            background-color: #ffffff;
            width: 90%;
            max-width: 600px;
            margin: 20px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header img {
            max-width: 100px;
        }
        .content {
            font-size: 16px;
            line-height: 1.5;
        }
        .footer {
            background-color: #198754;
            color: #ffffff;
            text-align: center;
            padding: 10px;
            border-radius: 0 0 8px 8px;
        }
        .footer a {
            color: #ffffff;
            margin: 0 5px;
            text-decoration: none;
        }
        @media (max-width: 600px) {
            body {
                height: auto;
                padding: 20px 0;
            }
            .email-container {
                width: 100%;
                margin: 0;
                padding: 10px;
                border-radius: 0;
            }
            .footer {
                padding: 20px 10px;
            }
        }
    </style>
</head>
<body>
    <div class='email-container'>
        <div class='header'>
            <img src='assets/images/logo-white-1.png' alt='Fair Law Firm'>
            <h2>Welcome to Fair Law Firm LTD</h2>
        </div>
        <div class='content'>
            <p><strong>.$title.</strong></p>
            <p><strong>$name</strong></p>
            <p><strong>Tel:</strong>$phone</p>
            <p><strong>Number of Guest:</strong>$guests</p>
            <p>$comments</p>
        </div>
        <div class='footer'>
            <p>Contact to Fair Law Firm feeds to be the first to hear about us, and we're here to provide legal services and property managment.</p>
            <p>
                <a href='#'>Website.com</a> |
                <a href='#'>Privacy Statement</a> |
                <a href='#'>Justice</a>
            </p>
        </div>
    </div>
</body>
</html>
    ";
    $mail->send();
    header("Location: property.php?");
    exit();
}
?>
