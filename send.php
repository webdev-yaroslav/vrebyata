<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Переменные, которые отправляет пользователь
$name = $_POST['name'];
$email = $_POST['phone'];
$text = $_POST['time'];
// $file = $_FILES['myfile'];

// Формирование самого письма
$title = "Заказ звонка";
$body = "<h1>Здравствуйте, я заказал(a) у вас звонок!</h1>";

if (trim(!empty($_POST['name']))) {
    $body.='<p><strong>Имя:</strong> '.$_POST['name'].'</p>';
  }
  if (trim(!empty($_POST['phone']))) {
    $body.='<p><strong>Номер телефона:</strong> '.$_POST['phone'].'</p>';
  }
  if (trim(!empty($_POST['time']))) {
    $body.='<p><strong>Удобное время для звонка:</strong> '.$_POST['time'].'</p>';
  }

// Настройки PHPMailer
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    //$mail->SMTPDebug = 2;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
    $mail->Username   = 'yaroslavponomarev.pro@gmail.com'; // Логин на почте
    $mail->Password   = 'toohevhnfqccmwtr'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('mail@gmail.com', 'Клиент'); // Адрес самой почты и имя отправителя

    // Получатель письма
    // $mail->addAddress('yaroslavponomarev10@gmail.com');  
    $mail->addAddress('yaroslavponomarev.pro@gmail.com'); // Ещё один, если нужен

    // Отправка сообщения
    $mail->isHTML(true);
    $mail->Subject = $title;
    $mail->Body = $body;    

    // Проверяем отравленность сообщения
    if ($mail->send()) {$result = "success";} 
    else {$result = "error";}

} catch (Exception $e) {
    $result = "error";
    $status = "Сообщение не было отправлено. Причина ошибки: {$mail->ErrorInfo}";
}

// Отображение результата
echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);