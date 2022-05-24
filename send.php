<?php
// Файлы phpmailer
require 'phpmailer/PHPMailer.php';
require 'phpmailer/SMTP.php';
require 'phpmailer/Exception.php';

// Переменные, которые отправляет пользователь
$name = $_POST['name'];
$phone = $_POST['phone'];
$time = $_POST['time'];
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

/* Попытка подключения к серверу MySQL. Предполагая, что вы используете MySQL
 сервер с настройкой по умолчанию (пользователь root без пароля) */
$link = mysqli_connect("localhost", "root", "root", "calls");
 
// Проверьте подключение
if($link === false){
    die("ERROR: Нет подключения. " . mysqli_connect_error());
}
 
//  экранирует специальные символы в строке
$name = mysqli_real_escape_string($link, $_REQUEST['name']);
$phone = mysqli_real_escape_string($link, $_REQUEST['phone']);
$time = mysqli_real_escape_string($link, $_REQUEST['time']);
 
// Попытка выполнения запроса вставки
$sql = "REPLACE INTO persons (name, phone, time) VALUES ('$name', $phone, '$time')";
if(mysqli_query($link, $sql)){
    echo json_encode(["result" => $result, "resultfile" => $rfile, "status" => $status]);
} else{
    echo "ERROR: Не удалось выполнить $sql. " . mysqli_error($link);
}

// Закрыть соединение
mysqli_close($link);
?>