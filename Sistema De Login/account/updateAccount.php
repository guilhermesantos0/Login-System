<?php declare(strict_types=1);
session_start(); ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Conta</title>
    <link rel="stylesheet" href="updateAccount.css">
</head>
<body>
    <form method="post" enctype="multipart/form-data">
        <div id="container">
            <div id="avatar">
                <img id="profilePicture" src="<?php echo $_SESSION['avatar'] ?>">
                <label for="updateAvatar" class="updateAvatar">Escolha um arquivo</label>
                <input type="file" name="newAvatar" id="updateAvatar">
            </div>
            <div id="username" class="flex-column">
                <label for="updateUsername"><?php echo $_SESSION['username'] ?></label>
                <input type="text" name="newUsername" id="updateUsername" class="test" placeholder="Novo nome de usuário" maxlength="15">
                <div class="line"></div>
            </div>
            <div id="email-phone" class="flex-column">
                <div id="email" class="flex-column">
                    <label for="updateEmail"><?php echo $_SESSION['email']; ?></label>
                    <input type="email" name="newEmail" id="updateEmail" class="test" placeholder="Novo email">
                    <div class="line"></div>
                </div>
                <div id="phone" class="flex-column">
                    <label for="updatePhone"><?php echo $_SESSION['phone']; ?></label>
                    <input type="tel" name="newPhone" id="updatePhone" class="test" placeholder="Novo número de telefone">
                    <div class="line"></div>
                </div>
            </div>
            <div id="buttons">
                <button type="submit" id="submitButton" name="save">Salvar</button>
                <button type="submit" id="changePassword" name = "changePassword">Alterar Senha</button>
            </div>
        </div>
    </form>
</body>

<script>
    
</script>
</html>

<?php

require_once '../classes/user.php';
$user = new User;

if( isset($_POST['save'])){
    $user_id = $_SESSION['user_id'];
    if( isset($_FILES['newAvatar']) && $_FILES['newAvatar']['error'] == 0){
        $fileName = $_FILES['newAvatar']['name'];
        $extension = pathinfo($fileName, PATHINFO_EXTENSION);
        $destination = "../avatars/$user_id.$extension";
        $file = $_FILES['newAvatar']['tmp_name'];
        
        if(!in_array($extension, ['png','jpg'])){
            ?>
                <div id="error" class="message">
                    Você deve enviar um arquivo .png ou .jpg!
                </div>
            <?php
        }elseif ($_FILES['newAvatar']['size'] > 5000000) {
            ?>
                <div id="error" class="message">
                    Arquivo muito grande!
                </div>
            <?php
        }else{
            if(in_array($extension, ['png'])){
                if(file_exists("../avatars/$user_id.png")){
                    unlink("../avatars/$user_id.png");
                }
            }else if(in_array($extension, ['jpg'])){
                if(file_exists("../avatars/$user_id.jpg")){
                    unlink("../avatars/$user_id.jpg");
                }
            }
            if(move_uploaded_file($file, $destination)){
                $user->updateAvatar($user_id);
                $_SESSION['avatar'] = $destination;
                header("Location: index.php");
                ?>
                    <div id="success" class="message">
                        Avatar alterado com sucesso!
                    </div>
                <?php
            }else{
                ?>
                    <div id="error" class="message">
                        Houve um erro com os nossos sistemas, tente novamente mais tarde!
                    </div>
                <?php
            };
        };
    }

    if(isset($_POST['newUsername']) && strlen($_POST['newUsername']) > 0){
        if($user->updateUsername($user_id, $_POST['newUsername'])){
            $_SESSION['username'] = $_POST['newUsername'];
            header("location: index.php");
            ?>
                <div id="success" class="message">
                    Nome de usuário alterado com sucesso!
                </div>
            <?php
        }else{
            ?>
                <div id="error" class="message">
                    Nome de usuário já registrado!
                </div>
            <?php
        };
        
    }
    if(isset($_POST['newEmail']) && strlen($_POST['newEmail']) > 0){
        if($user->updateEmail($user_id, $_POST['newEmail'])){
            $_SESSION['email'] = $_POST['newEmail'];
            header("Location: index.php");
            ?>
                <div id="success" class="message">
                    Email alterado com sucesso!
                </div>
            <?php
        }else{
            ?>
                <div id="error" class="message">
                    Este endereço já está sendo utilizado!
                </div>
            <?php
        };
        
    }
    if(isset($_POST['newPhone']) && strlen($_POST['newPhone']) > 0){
        if($user->updatePhone($user_id, $_POST['newPhone'])){
            $_SESSION['phone'] = $_POST['newPhone'];
            header("Location: index.php");
            ?>
                <div id="success" class="message">
                    Número de telefone alterado com sucesso!
                </div>
            <?php
        }else{
            ?>
                <div id="error" class="message">
                    Este número de telefone já está sendo utilizado!
                </div>
            <?php
        };
        
    }
}else if(isset($_POST['changePassword'])){
    header("location: changePassword.php");  
};

?>