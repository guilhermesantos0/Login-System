<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>
<body>
    <form method="post">
        <div id="registerArea">
            <div id="nameArea" class="area">
                <label for="name">Nome completo:</label>
                <input type="text" placeholder="Nome completo" name="name" id="name">
                <div class="line"></div>
            </div>
            <div id="usernameArea" class="area">
                <label for="username">Nome de usuário:</label>
                <input type="text" placeholder="Nome de usuário" name="username" id="username">
                <div class="line"></div>
            </div>
            <div id="phoneArea" class="area">
                <label for="phone">Telefone:</label>
                <input type="tel" placeholder="Telefone" name="phone" id="phone">
                <div class="line"></div>
            </div>
            <div id="emailArea" class="area">
                <label for="email">Email:</label>
                <input type="email" placeholder="Email" name="email" id="email">
                <div class="line"></div>
            </div>
            <div id="passwordArea" class="area">
                <label for="password">Senha:</label>
                <input type="password" placeholder="Senha" name="password" id="password">
                <div class="line"></div>
            </div>
            <input type="submit" value="Cadastrar"></input>
            <div id="otherOptions">
                <div id="voltar"><a href="../index.php"><i class="fas fa-arrow-left"></i> Voltar</a></div>
                <div id="login">Já tem uma conta?<br><a href="../login/index.php"><p>Login</p></a></div>
            </div>
        </form>
    </div>
</body>
</html>

<?php

    require_once '../classes/user.php';
    $user = new User;

    if( isset($_POST['name']) ){
        $name = $_POST['name'];
        $username = $_POST['username'];
        $phone = $_POST['phone'];
        $email = $_POST['email'];
        $password = $_POST['password'];

        if(!empty($name) && !empty($username) && !empty($phone) && !empty($email) && !empty($password)){
            if(!$user->register($name,$username,$phone,$email,$password)){
                ?>
                    <div id="succes" class="message">
                        Cadastrado com sucesso!
                    </div>
                <?php
            }else{
                ?>
                    <div id="error" class="message">
                        Usuário já cadastrado!
                    </div>
                <?php
            };
        }else{
            ?>
                <div id="error" class="message">
                    Preencha todos os campos!
                </div>
            <?php
        };
    }

?>
