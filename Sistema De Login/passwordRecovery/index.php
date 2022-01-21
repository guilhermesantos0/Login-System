<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de senha</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <form method="post">
        <div id="container">
            <div id="email">
                <span>Endereço de email cadastrado:</span>
                <input type="email" placeholder="Endereço de email cadastrado" name="email">
            </div>
            <input type="submit" id="submit" value="Enviar código">
        </div>
    </form>
</body>
</html>

<?php

    require_once '../classes/user.php';
    $user = new User;

    require_once('../mailer/src/PHPMailer.php');
    require_once('../mailer/src/SMTP.php');
    require_once('../mailer/src/Exception.php');

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);

    if( isset($_POST['email'])){
        if($user->checkMail($_POST['email'])){
            try{

                $userMail = $_POST['email'];
                $userId = $user->getUserIdByEmail($userMail);

                $mail->STMPDebug = SMTP::DEBUG_SERVER;
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->SMTPAutoTLS = true;
                $mail->Username = ""; // email do remetente (sua empresa) [gmail]
                $mail->Password = ""; // senha do email da empresa [gmail]
                $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                $mail->Port = 465;
            
                $mail->setFrom(""); // email do remetente (sua empresa) [gmail]
                $mail->addAddress($userMail);
            
                $mail->isHTML(true);
                $mail->Subject = "Recuperacao de senha";
                $mail->Body = "Para recuerar sua senha <a href='http://127.0.0.1:5000/passwordRecovery/recovery.php?uid=$userId&auth=true'>Clique Aqui</a>!<br>Se nao funcionar, acesse este link: http://127.0.0.1/passwordRecovery/recovery.php";
                $mail->altBody = "Para recuerar sua senha acesse este link: http://127.0.0.1:5000/passwordRecovery/recovery.php?uid=$userId&auth=true";

                if($mail->send()){
                    ?>
                        <div id="succes" class="message">Email enviado!</div>
                    <?php
                }else{
                    ?>
                        <div id="error" class="message">Email não encontrado!</div>
                    <?php
                }
            
            }catch(Exception $e){
                echo "Erro ao enviar email: $mail->ErrorInfo";
            }
        }
    }

?>