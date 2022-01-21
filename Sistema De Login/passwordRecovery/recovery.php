<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Recuperação de Senha</title>
    <link rel="stylesheet" href="recoveryStyle.css">
</head>
<body>
    <form method="post">
        <div id="container">
            <div id="password" class="area">
                <span>Senha:</span>
                <input type="password" name="password" id="password" placeholder="Senha">
            </div>
            <div id="passwordConfirm" class="area">
                <span>Confirmar senha:</span>
                <input type="password" name="confirmPassword" id="confirmPassword" placeholder="Confirmar senha">
            </div>
            <input type="submit" value="Redefinir senha">
            <div id="otherOptions">
                <div id="login"><a href="../login/index.php">Fazer login</a></div>
            </div>
        </div>
    </form>
</body>
</html>

<?php

$userid = $_GET['uid'];
$authenticated = $_GET['auth'];

require_once '../classes/user.php';
$user = new User;

if($authenticated == "true"){
    if(isset($_POST['password']) && isset($_POST['confirmPassword']) && $userid){
    
        if(!empty($_POST['password']) && !empty($_POST['confirmPassword'])){
            if($_POST['password'] == $_POST['confirmPassword']){
                $user->redefinePassword($userid, $_POST['password']);
                ?>
                    <div id="succes" class="message">Senha redefinida com sucesso!</div>
                <?php
            }else{
                ?>
                    <div id="error" class="message">As senhas não coincidem!</div>
                <?php
            }
        }
    }
}


?>