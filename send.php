<?php
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';
require 'db.php';

// Запись в БД
// if($link === false){
//     die("ERROR: Нет подключения. " . mysqli_connect_error());
// }

// $name = mysqli_real_escape_string($link, $_REQUEST['name']);
// $phone = mysqli_real_escape_string($link, $_REQUEST['phone']);
// $time = mysqli_real_escape_string($link, $_REQUEST['time']);

// $sql = "INSERT INTO persons (name, phone, time) VALUES ('$name', '$phone', '$time')";
// if(mysqli_query($link, $sql)){
//     echo "SUCCES: Удалось выполнить $sql. " . mysqli_error($link);
// } else{
//     echo "ERROR: Не удалось выполнить $sql. " . mysqli_error($link);
// }

$name = $_POST['name'];
$phone = $_POST['phone'];
$time = $_POST['time'];

// Формирование письма
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

// Отправка письма
$mail = new PHPMailer\PHPMailer\PHPMailer();
try {
    $mail->isSMTP();   
    $mail->CharSet = "UTF-8";
    $mail->SMTPAuth   = true;
    $mail->Debugoutput = function($str, $level) {$GLOBALS['status'][] = $str;};

    // Настройки вашей почты
    $mail->Host       = 'smtp.gmail.com'; // SMTP сервера вашей почты
    $mail->Username   = 'yaroslavponomarev.pro@gmail.com'; // Логин на почте
    $mail->Password   = 'toohevhnfqccmwtr'; // Пароль на почте
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->setFrom('mail@gmail.com', 'Клиент'); // Адрес самой почты и имя отправителя

    // Получатель письма
    $mail->addAddress('veselyerebyata64@yandex.ru');  
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

echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);