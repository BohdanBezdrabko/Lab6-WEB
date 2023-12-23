<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

// Ваш токен Telegram бота та ідентифікатор каналу
$telegramBotToken = "1858844290:AAG4xVcUFcD6nNnKqz1biKvcGrhwNCsOHMk";
$telegramChannelId = "-519873227";;

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];

    // Конфігурація PHPMailer
    $mail = new PHPMailer(true);

    try {
        // Ваша раніше вказана конфігурація

        // Telegram повідомлення
        $telegramMessage = "Нове повідомлення від:\nІм'я: $name\nЕлектронна пошта: $email\nТема: $subject\nПовідомлення: $message";

        // Відправлення повідомлення в Telegram канал
        sendTelegramMessage($telegramBotToken, $telegramChannelId, $telegramMessage);

        // Відправлення повідомлення на електронну пошту
        $mail->setFrom($email, $name);
        $mail->addAddress('webkpi21@gmail.com'); 
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "Ім'я: $name <br> Електронна пошта: $email <br> Тема: $subject <br> Повідомлення: $message";
        $mail->send();

        // Виведення результату
        echo 'Повідомлення відправлено успішно';
    } catch (Exception $e) {
        echo "Помилка відправлення повідомлення: {$mail->ErrorInfo}";
    }
}

// Функція для відправлення повідомлення в Telegram канал
function sendTelegramMessage($token, $chatId, $message) {
    $url = "https://api.telegram.org/bot$token/sendMessage";
    $params = [
        'chat_id' => $chatId,
        'text' => $message,
    ];

    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_POST, 1);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $result = curl_exec($ch);
    curl_close($ch);

    return $result;
}
?>
