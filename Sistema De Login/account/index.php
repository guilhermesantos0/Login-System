<?php

session_start();
if(!isset($_SESSION['user_id'])){
    header("location: ../index.php");
    exit;
}

require_once '../classes/user.php';
$user = new User;

$user_id = $_SESSION['user_id'];

global $userInfos;
$userInfos = $user->getInfos($user_id);

$_SESSION['username'] = $userInfos['username'];
$_SESSION['avatar'] = $userInfos['avatar'];
$_SESSION['email'] = $userInfos['email'];
$_SESSION['phone'] = $userInfos['phone'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logado</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.15.4/css/all.css" integrity="sha384-DyZ88mC6Up2uqS4h/KRgHuoeGwBcD4Ng9SiP4dIRy0EXTlnuz47vAwmeGwVChigm" crossorigin="anonymous">
</head>
<body>
    <div id="containerInfos">
        <div id="username">
            <img id="profilePicture" src="<?php echo $userInfos['avatar'] ?>">
            <h2><?php echo $userInfos['username'] ?></h2>
            <div id="updateProfile">
                <form method="post">
                    <a href="updateAccount.php"><i class="fas fa-edit"></i> Editar</a>
                </form>
            </div>
        </div>
        <div id="otherInfos">
            <div id="email">
                <h3>Email</h3>
                <h4><?php echo $userInfos['email']?></h4>
            </div>
            <div id="phone">
                <h3>Telefone</h3>
                <h4><?php echo $userInfos['phone'] ?></h4>
            </div>
        </div>
        <div id="return">
            <form method="post">
                <a href="logout.php"><i class="fas fa-arrow-left"></i> Sair</a>
            </form>
        </div>
    </div>
</body>
</html>
