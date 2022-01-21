<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>
<body>
    <form method="post">
        <div id="loginArea">
            <div id="usernameArea" class="area">
                <label for="username">Nome de usuário ou email:</label>
                <input type="text" placeholder="Nome de usuário ou email" name="username" id="username">
                <div class="line"></div>
            </div>
            <div id="passwordArea" class="area">
                <label for="password">Senha:</label>
                <input type="password" placeholder="Senha" name="password" id="password">
                <div class="line"></div>
            </div>
            <input type="submit" id="login" value="Login"></input>
            <div id="passwordRecovery"><a href="../passwordRecovery/index.php">Esqueceu sua senha?</a></div>
            <div id="otherOptions">
                <div id="voltar"><a href="../index.php"><i class="fas fa-arrow-left"></i> Voltar</a></div>
                <div id="cadastro">Não tem uma conta?<br><a href="../cadastro/index.php"><p>Cadastre-se</p></a></div>
            </div>
        </div>
    </form>
</body>
</html>

<?php

    require_once '../classes/user.php';
    $user = new User;

    if( isset($_POST['username']) ){

        $username = $_POST['username'];
        $password = $_POST['password'];

        if(!empty($username) && !empty($password)){
            if($user->login($username,$password)){
                header("location: ../account/index.php");
            }else{
                ?>
                    <div id="error" class="message">
                        Usuário e/ou senha incorretos!
                    </div>
                <?php
            }
        }else{
            ?>
                <div id="error" class="message">
                    Preencha todos os campos!
                </div>
            <?php
        }
    }

?>