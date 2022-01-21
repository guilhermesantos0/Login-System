<?php



global $mail;


class User{

    public function register($name, $username, $phone, $email, $password){

        try{
            $pdo = new PDO("mysql:dbname=login;host=localhost","root","");
        }catch (PDOException $e){
            echo "Erro com o banco de dados: " .$e->getMessage();
            return;
        }catch (Exception $e){
            echo "Erro genérico: ".$e->getMessage();
            return;
        };

        $sql = $pdo->prepare("SELECT * FROM users WHERE user_username = :u");
        $sql->bindValue(":u",$username);
        $sql->execute();

        if($sql->rowCount() > 0){

            return false;

        }else {


            $newSql = $pdo->prepare("INSERT INTO users (user_name, user_username, user_phone, user_email, user_password) VALUES(:name,:username,:phone,:email,:password)");
            
            $newSql->bindValue(":name",$name);
            $newSql->bindValue(":username",$username);
            $newSql->bindValue(":phone",$phone);
            $newSql->bindValue(":email",$email);
            $newSql->bindValue(":password",str_replace(" ", "", $password));

            $newSql->execute();

        };

    }

    public function login($username, $password){

        try{
            $pdo = new PDO("mysql:dbname=login;host=localhost","root","");
        }catch (PDOException $e){
            echo "Erro com o banco de dados: " .$e->getMessage();
            return;
        }catch (Exception $e){
            echo "Erro genérico: ".$e->getMessage();
            return;
        };

        $sql = $pdo->prepare("SELECT * FROM users WHERE user_username = :u");
        $sql->bindValue(":u",$username);
        $sql->execute();

        if($sql->rowCount() > 0){
            $result = $sql->fetch();
            if($result['user_password'] == $password){
                session_start();
                $_SESSION['user_id'] = $result['user_id'];
                return true;
            }else{
                return false;
            }
        }else {
            $sql = $pdo->prepare("SELECT * FROM users WHERE user_email = :u");
            $sql->bindValue(':u',$username);
            $sql->execute();

            if($sql->rowCount() > 0){
                $result = $sql->fetch();
                if($result['user_password'] == $password){
                    session_start();
                    $_SESSION['user_id'] = $result['user_id'];
                    return true;
                }else{
                    return false;
                }
            }else{
                return false;
            };
        };
    }

    public function getInfos($userid){

        try{
            $pdo = new PDO("mysql:dbname=login;host=localhost","root","");
        }catch (PDOException $e){
            echo "Erro com o banco de dados: " .$e->getMessage();
            return;
        }catch (Exception $e){
            echo "Erro genérico: ".$e->getMessage();
            return;
        };

        $sql = $pdo->prepare("SELECT * FROM users WHERE user_id = :u");
        $sql->bindValue(':u',$userid);
        $sql->execute();

        
        if($sql->rowCount() > 0){
            $result = $sql->fetch();
            $userPhone = formatPhoneNumber($result['user_phone']);
            $userAvatar = file_exists("../avatars/$userid.png") ? "../avatars/$userid.png": "../avatars/$userid.jpg";
            $userAvatarFile = $result['user_avatar'] == 0 ? "../avatars/default_profile.jpg" : "$userAvatar";
            $userInfos = [
                "username" => $result['user_username'],
                "phone" => $userPhone,
                "email" => $result['user_email'],
                "avatar" => $userAvatarFile
            ];

            return $userInfos;
        };
    }

    public function checkMail($email){

        try{
            $pdo = new PDO("mysql:dbname=login;host=localhost","root","");
        }catch (PDOException $e){
            echo "Erro com o banco de dados: " .$e->getMessage();
            return;
        }catch (Exception $e){
            echo "Erro genérico: ".$e->getMessage();
            return;
        };

        $sql = $pdo->prepare("SELECT * FROM users WHERE user_email = :u");
        $sql->bindValue(':u',$email);
        $sql->execute();

        if($sql->rowCount() > 0){
            return true;
        }else{
            return false;
        };
    }

    public function getUserIdByEmail($email){

        try{
            $pdo = new PDO("mysql:dbname=login;host=localhost","root","");
        }catch (PDOException $e){
            echo "Erro com o banco de dados: " .$e->getMessage();
            return;
        }catch (Exception $e){
            echo "Erro genérico: ".$e->getMessage();
            return;
        };

        
        $sql = $pdo->prepare("SELECT * FROM users WHERE user_email = :u");
        $sql->bindValue(':u',$email);
        $sql->execute();

        if($sql->rowCount() > 0){
            $result = $sql->fetch();
            return $result['user_id'];
        }else{
            return false;
        };

    }

    public function redefinePassword($user_id, $password){

        try{
            $pdo = new PDO("mysql:dbname=login;host=localhost","root","");
        }catch (PDOException $e){
            echo "Erro com o banco de dados: " .$e->getMessage();
            return;
        }catch (Exception $e){
            echo "Erro genérico: ".$e->getMessage();
            return;
        };

        $sql = $pdo->prepare("UPDATE users SET user_password = :p WHERE user_id = :u");
        $sql->bindValue(':p',$password);
        $sql->bindValue(':u',intval($user_id));
        $sql->execute();

    }

    public function updateAvatar($user_id){

        try{
            $pdo = new PDO("mysql:dbname=login;host=localhost","root","");
        }catch (PDOException $e){
            echo "Erro com o banco de dados: " .$e->getMessage();
            return;
        }catch (Exception $e){
            echo "Erro genérico: ".$e->getMessage();
            return;
        };

        $sql = $pdo->prepare("UPDATE users SET user_avatar = 1 WHERE user_id = :u");
        $sql->bindValue(':u',$user_id);
        $sql->execute();

    }

    public function updateUsername($user_id, $newUsername){

        try{
            $pdo = new PDO("mysql:dbname=login;host=localhost","root","");
        }catch (PDOException $e){
            echo "Erro com o banco de dados: " .$e->getMessage();
            return;
        }catch (Exception $e){
            echo "Erro genérico: ".$e->getMessage();
            return;
        };

        $sql = $pdo->prepare("SELECT * FROM users WHERE user_username = :nu");
        $sql->bindValue(":nu",$newUsername);
        $sql->execute();

        if($sql->rowCount() > 0){

            return false;

        }else{
            $sql = $pdo->prepare("UPDATE users SET user_username = :nu WHERE user_id = :u");
            $sql->bindValue(':u',$user_id);
            $sql->bindValue(':nu',$newUsername);
            $sql->execute();

            return true;
        };


    }

    public function updateEmail($user_id, $newEmail){

        try{
            $pdo = new PDO("mysql:dbname=login;host=localhost","root","");
        }catch (PDOException $e){
            echo "Erro com o banco de dados: " .$e->getMessage();
            return;
        }catch (Exception $e){
            echo "Erro genérico: ".$e->getMessage();
            return;
        };

        $sql = $pdo->prepare("SELECT * FROM users WHERE user_email = :ne");
        $sql->bindValue(":nu",$newEmail);
        $sql->execute();

        if($sql->rowCount() > 0){

            return false;

        }else{
            $sql = $pdo->prepare("UPDATE users SET user_email = :ne WHERE user_id = :u");
            $sql->bindValue(':u',$user_id);
            $sql->bindValue(':ne',$newEmail);
            $sql->execute();
            
            return true;
        }


    }

    public function updatePhone($user_id, $newPhone){

        try{
            $pdo = new PDO("mysql:dbname=login;host=localhost","root","");
        }catch (PDOException $e){
            echo "Erro com o banco de dados: " .$e->getMessage();
            return;
        }catch (Exception $e){
            echo "Erro genérico: ".$e->getMessage();
            return;
        };

        $sql = $pdo->prepare("SELECT * FROM users WHERE user_phone = :np");
        $sql->bindValue(":nu",$newEmail);
        $sql->execute();

        if($sql->rowCount() > 0){

            return false;

        }else{
            $sql = $pdo->prepare("UPDATE users SET user_phone = :np WHERE user_id = :u");
            $sql->bindValue(':u',$user_id);
            $sql->bindValue(':np',$newPhone);
            $sql->execute();

            return true;
        }

    }

    public function updatePassword($userid, $oldPassword, $newPassword){

        try{
            $pdo = new PDO("mysql:dbname=login;host=localhost","root","");
        }catch (PDOException $e){
            echo "Erro com o banco de dados: " .$e->getMessage();
            return;
        }catch (Exception $e){
            echo "Erro genérico: ".$e->getMessage();
            return;
        };

        $sql = $pdo->prepare("SELECT * FROM users WHERE user_id = :u");
        $sql->bindValue(":u",$userid);
        $sql->execute();

        $arr = [ "oldPassword" => $oldPassword, "newPassword" => $newPassword ];
        if($sql->rowCount() > 0){
            $result = $sql->fetch();
            if($result['user_password'] == $oldPassword){
                if(strcmp($newPassword, $result['user_password']) == 0){
                   
                    $return = [ "status" => false, "Type" => 1 ];
                    return $return;
                }else{
                    $nsql = $pdo->prepare("UPDATE users SET user_password = :p WHERE user_id = :u");
                    $nsql->bindValue(":p",$newPassword);
                    $nsql->bindValue(":u",$userid);
                    $nsql->execute();
    
                    $return = [ "status" => true, "Type" => 0 ];
                    return $return;
                }
            }else{
                $return = [ "status" => false, "Type" => 2 ];
                return $return;
            };
        }
    }
};

function formatPhoneNumber($phoneNumber){
    if(  preg_match( '/^\+(\d{2})(\d{2})(\d{5})(\d{4})$/', $phoneNumber,  $matches ) ){
        $result = '+' . $matches[1] . ' ' .$matches[2] . ' ' . $matches[3] . '-' .$matches[4] ;
        return $result;
    }
}