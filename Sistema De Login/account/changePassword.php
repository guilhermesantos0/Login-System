<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="changePassword.css">
</head>
<body>
    <form method="post">
        <div id="container">
            <div id="actualPassword">
                <label for="oldPassword">Senha atual:</label>
                <input type="password" name="oldPassword" id="oldPassword">
                <div class="line"></div>
            </div>
            <div id="newPassword">
                <label for="newPassword">Nova senha:</label>
                <input type="password" name="newPassword" id="newPassword">
                <div class="line"></div>
            </div>
            <div id="confirmPassword">
                <label for="confirmPassword">Confirmar senha:</label>
                <input type="password" name="confirmPassword" id="confirmPassword">
                <div class="line"></div>
            </div>
            <button type="submit" id="submit" name="save">Salvar</button>
            <div id="passwordRecovery"><a href="../passwordRecovery/index.php">Esqueceu sua senha?</a></div>
        </div>
    </form>
</body>
</html>

<?php

session_start();

require_once '../classes/user.php';
$user = new User;

if(isset($_POST['save'])){
    if(!is_null($_POST['oldPassword']) && !is_null($_POST['newPassword']) && !is_null($_POST['confirmPassword'])){
        if($_POST['newPassword'] == $_POST['confirmPassword']){
            $result = $user->updatePassword($_SESSION['user_id'], $_POST['oldPassword'], $_POST['newPassword']);
            if($result['Type'] == 0){
                ?>
                    <div id="succes" class="message">
                        Senha alterada com sucesso!
                    </div>
                <?php
                sleep(2);
                header("location: index.php");
            }else if($result['Type'] == 1){
                ?>
                    <div id="error" class="message">
                        Sua nova senha não pode ser igual à atual!
                    </div>
                <?php
            }else if($result['Type'] == 2){
                ?>
                    <div id="error" class="message">
                        Senha errada!
                    </div>
                <?php
            }
        }else{
            ?>
                <div id="error" class="message">
                    As senhas não coincidem!
                </div>
            <?php
        }
    }else{
        ?>
            <div id="error" class="message">
                Preencha todos os dados!
            </div>
        <?php
    }
}

?>