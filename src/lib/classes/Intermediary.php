<?php
namespace Space;

final class Intermediary {
     private static $root_relative_path = "../..";

    /**
     * Validate the necessary informations to register a star and attempt to create it 
     * @param string $name - the name of the star
     * @param string $password - the password of the star
     * @return bool - true for sucess and false for failure
     */
    public static function RegisterStar(string $name, string $password) {

        //Check for invalid fields   
        if (!Star::IsValidName($name) || !Star::IsValidPassword($password)) {

            if (!Star::IsValidName($name))
                $msg = "<span style='color:red'>Nome inválido!</span>";
            if (!Star::IsValidPassword($password))
                $msg = "<span style='color:red'>Palavra-passe inválida!!</span>";

            header("location: ".self::$root_relative_path."/register.php?msg=$msg");
            return false;
        }

        //Verify if the name is already registered
        if (Star::IsRegisteredName($name)) {
            $msg = "O nome '$name' já pertence à uma estrela! Use outro nome.";
            header("location: ".self::$root_relative_path."/register.php?msg=$msg");
            return false;
        }


        //Try to create the star
        if (Star::CreateStar($name, $password)) {
            $id = Star::GetStarId($name);

            $star_dir = self::$root_relative_path."/images/stars/star" . $id;

            if (!mkdir($star_dir) || !copy(self::$root_relative_path."/images/stars/default.png", $star_dir . "/default.png")) {
                (new Star($id))->Notify("Registro", "Não foi possível criar os ficheiros para a tua estrela! Reporte este erro.");
            }
        } else {
            $msg = "Lamentamos, não foi possível criar esta estrela! Tente novamente.";
            header("location: ".self::$root_relative_path."/register.php?msg=$msg");
            return false;
        }

        return true;
    }

    /**
     * Validate the necessary informations to login and attempt to login  
     * @param string $name - the name of the star
     * @param string $password - the password of the star
     * @return bool - true for sucess and false for failure
     */
    public static function Login(string $name, string $password): bool {

        if (!Star::IsValidName($name)) {
            $msg = "<span style='color:red'>Nome inválido!</span>";
            header("location: ".self::$root_relative_path."/login.php?msg=$msg");
            return false;
        }

        if (!Star::IsValidPassword($password)) {
            $msg = "<span style='color:red'>Palavra-passe inválida!</span>";
            header("location: ".self::$root_relative_path."/login.php?msg=$msg");
            return false;
        }

        if (!Star::IsRegisteredName($name)) {
            $msg = "O nome <b class='link-star'>@$name</b> ainda não foi registrado, <a class='link-simple' href='register.php?star_name=$name'>crie uma estrela com este nome.</a>";
            header("location: ".self::$root_relative_path."/login.php?msg=$msg");
            return false;
        }

        $star = new Star(Star::GetStarID($name));

        //Check whether the password is correct
        if ($star->IsPassword($password)) {

            //Try to Login
            if (Star::LogIn($star->GetId())) {
                header("location: ".self::$root_relative_path."/home.php");
            } else {
                $msg = "Lamentamos, por algum motivo não foi possível entrar no space.";
                header("location: ".self::$root_relative_path."/login.php?msg=$msg");
                return false;
            }

            //The password is incorrect    
        } else {
            $msg = "<span style='color:red'>Palavra-passe incorreta!</span>";
            header("location: ".self::$root_relative_path."/login.php?msg=$msg");
            return false;
        }

        return true;
    }

    public static function SendPost($const, string $content) {

        if (!is_numeric($const) || empty($const)) {
            $msg = "Constelação inválida!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        if (!Constellation::Exists($const)) {
            $msg = "Constelação não identificada!";
            header("location: ../error.php?msg=$msg");
            return false;
        }

        $content = trim($content);

        if (!Post::IsValidPostContent($content)) {
            $msg = "Conteúdo para post Inválido!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        if ((new Constellation($const))->ContainsStar(Star::MyStar()->GetId()) == false) {
            $msg = "Você não pertence à esta constelação!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        if (Star::MyStar()->SendPost($const, $content)) {
            header("location: ".self::$root_relative_path."/constellation.php?const=$const");
        } else {
            $msg = "Não foi possível enviar o post.";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        return true;
    }

    /**
     * Alter the informations of the current star after validating the new informations
     * @param string $current_password - the current password
     * @param string $new_name -  the new name for the star
     * @param string $new_password -  string the new password for the star
     * @param string $new_description - the new description for the star
     * @return bool true for success and false for failure
     */
    public static function UpdateInformations(string $current_password, string $new_name, string $new_password, string $new_description) {


        //Verify whether the current_password is correct
        if (!Star::MyStar()->IsPassword($current_password)) {
            $msg = "<span style='color:red;'>A palavra-passe actual está incorrecta!</span>";
            header("location: ".self::$root_relative_path."/updateinf.php?msg=$msg");
            return false;
        }

        //Name Alteration
        if (Star::IsValidName($new_name) && $new_name != Star::MyStar()->GetName()) {
            if (!Star::MyStar()->AlterName($new_name)) {
                $msg = "<span style='color:red;'>Lamentamos, não foi possível alterar o nome.</span>";
                header("location: ".self::$root_relative_path."/updateinf.php?msg=$msg");
                return false;
            } else {
                $content = "O nome da tua estrela agora é <a href='profile.php' class='link-star'>@$new_name</a>.";
                Star::MyStar()->Notify("Alteração de dados", $content);
            }
        }

        //Password Alteration
        if (Star::IsValidPassword($new_password) && !Star::MyStar()->IsPassword($new_password)) {
            if (!Star::MyStar()->AlterPassword($new_password)) {
                $msg = "<span class='color-red'>Não foi possível alterar a senha.</span>";
                header("location: ".self::$root_relative_path."/updateinf.php?msg=$msg");
                return false;
            } else {
                $content = urlencode("Alteraste a palavra-passe da tua estrela.");
                Star::MyStar()->Notify("Alteração de dados", $content);
            }
        }

        //Description Alteration
        if (Star::IsValidDescription($new_description) && $new_description != Star::MyStar()->GetDescription()) {
            if (!Star::MyStar()->AlterDescription($new_description)) {
                $msg = "<span class='color-red'>Não foi possível alterar a descrição.</span>";
                header("location: ".self::$root_relative_path."/updateinf.php?msg=$msg");
                return false;
            } else {
                $content = "A tua estrela tem uma nova descrição, <a class='link-simple' href='profile.php'>consulte no perfil</a>.";
                Star::MyStar()->Notify("Alteração de dados", $content);
            }
        }


        header("location: ".self::$root_relative_path."/updateinf.php");
        return true;
    }

    public static function SendCommentary(int $postid, string $content) {

        //Validity Check
        if (!Post::Exists($postid) || !Post::IsValidPostContent($content)) {
            $msg = "Post não identificado ou conteúdo inválido para o comentário.";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        $post = new Post($postid);

        if (!$post->GetConstellation()->ContainsStar(Star::MyStar()->GetId())) {
            $msg = "Você não pertence à esta constelação";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        if ($post->Comment(Star::MyStar()->GetId(), $content)) {

            //If MyStar is not the owner of the commentary, notify the owner 
            if ($post->GetOwner()->GetId() != Star::MyStar()->GetId()) {
                $myname = Star::MyStar()->GetName();
                $post->GetOwner()->Notify("Comentário", "<a class=link-star >@$myname</a> comentou o teu <a class=link-simple href=post.php?postid=$postid>post</a>.");
            }
        } else {
            $msg = "Não foi possível enviar o comentário!";
            header("location: ".self::$root_relative_path."/error.php=msg=$msg");
            return false;
        }

        header("location: ".self::$root_relative_path."/post.php?post=$postid");
        return true;
    }

    public static function ReportError(string $content) {

        if (!ReportedError::IsValidContent($content)) {
            $msg = "Conteúdo inválido!";
            header("location: ".self::$root_relative_path."/report_error.php?msg=$msg");
            return false;
        }

        if (!ReportedError::ReportError($content)) {
            $msg = "Não foi possível relatar o erro que encontrou";
            header("location: ".self::$root_relative_path."/report_error.php?msg=$msg");
            return false;
        }

        $msg = "O Space agradece pelo erro reportado, tentaremos resolvê-lo o mais rápido possível.";
        Star::MyStar()->Notify("Space", "Agradecemos pela reportagem do erro que encontrou.");
        header("location: ".self::$root_relative_path."/report_error.php?msg=$msg");

        return true;
    }

    public static function EditPost($postid, string $content) {
        
        if(!Post::IsValidPostContent($content)){
            $msg = "Conteúdo inválido para post!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        if (!Post::Exists($postid)) {
            $msg = "Post não identificado!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        $post = new Post($postid);
        if ($post->GetOwner()->GetId() != Star::MyStar()->GetId()) {
            $msg = "Acesso negado!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        if (!$post->EditPost($content)) {
            $msg = "Não foi possível editar o post!";
            header("location: ".self::$root_relative_path."/editpost.php?post=$postid&msg=$msg");
            return false;
        }
       
        header("location: ".self::$root_relative_path."/post.php?post=$postid");
        return true;
    }

    public static function EditCommentary($commentid, string $content) {
        
        if(!Post::IsValidPostContent($content)){
            $msg = "Conteúdo inválido para comentário!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        if (!Commentary::Exists($commentid)) {
            $msg = "Comentário não identificado!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        $commentary = new Commentary($commentid);
        if ($commentary->GetOwner()->GetId() != Star::MyStar()->GetId()) {
            $msg = "Acesso negado!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        if (!$commentary->EditCommentary($content)) {
            $msg = "Não foi possível editar o comentário!";
            header("location: ".self::$root_relative_path."/editcomment.php?comment=$commentid&msg=$msg");
            return false;
        }
       
        header("location: ".self::$root_relative_path."/post.php?post={$commentary->GetPost()->GetId()}");
        return true;
    }
    
    public static function DeletePost($postid){
        if (!Post::Exists($postid)) {
            $msg = "Post não identificado!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        $post = new Post($postid);
        if ($post->GetOwner()->GetId() != Star::MyStar()->GetId()) {
            $msg = "Acesso negado!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        if (!$post->Delete()) {
            $msg = "Não foi possível apagar o post!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        $const = $post->GetConstellation()->GetId();
        header("location: ".self::$root_relative_path."/constellation.php?const=$const");
        return true;
    }

    public static function DeleteNotification($notid) {

        if (!Notification::Exists($notid)) {
            $msg = "Notificação não identificada!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        $notification = new Notification($notid);
        if ($notification->GetOwner()->GetId() != Star::MyStar()->GetId()) {
            $msg = "Acesso negado!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        if (!$notification->Delete()) {
            $msg = "Não foi possível apagar a notification!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        header("location: ".self::$root_relative_path."/notification.php");
        return true;
    }

    public static function DeleteCommentary(int $commentid) {
        if (!Commentary::Exists($commentid)) {
            $msg = "Comentário não identificado!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        $commentary = new Commentary($commentid);
        if ($commentary->GetOwner()->GetId() != Star::MyStar()->GetId()) {
            $msg = "Acesso negado!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        if (!$commentary->Delete()) {
            $msg = "Não foi possível apagar o comentário!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        $postid = $commentary->GetPost()->GetId();
        header("location: ".self::$root_relative_path."/post.php?post=$postid");
        return true;
    }

    public static function ClearMyNotifications() {
        if (!Star::MyStar()->ClearNotifications()) {
            $msg = "Não foi possivel apagar todas as notificações!";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }
        header("location: ".self::$root_relative_path."/notification.php");
        return true;
    }

    public static function JoinConstellation($const) {

        if (!is_numeric($const))
            $const = -1;

        if (!Constellation::Exists($const) || empty($const)) {
            $msg = "Constelação não identificada";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }
        $star = Star::MyStar();

        $constellation = new Constellation($const);
        if ($constellation->AddStar($star->GetId()) == false) {
            $msg = "Não foi possível realizar a inserção.";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }


        $content = "<span class='link-star'>@" . $star->GetName() . "</span> foste inserido na constelação <a class='link-simple' href='constellation.php?const=$const'>" . $constellation->GetName() . "</a>";
        $star->Notify("Constelação", $content);

        header("location: ".self::$root_relative_path."/consts.php");
        return true;
    }

    public static function LeaveConstellation($const) {

        if (!is_numeric($const))
            $const = -1;

        if (!Constellation::Exists($const) || empty($const)) {
            $msg = "Constelação não identificada";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        $star = Star::MyStar();
        $constellation = new Constellation($const);

        if (!$constellation->ContainsStar($star->GetId())) {
            $msg = "A tua estrela não faz parte desta constelação.";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }

        if ($constellation->RemoveStar($star->GetId()) == false) {
            $msg = "Não foi possível realizar a remoção.";
            header("location: ".self::$root_relative_path."/error.php?msg=$msg");
            return false;
        }


        $content = "<span class='link-star'>@" . $star->GetName() . "</span> foste removido da constelação <a class='link-simple' href='constellation.php?const=$const'>" . $constellation->GetName() . "</a>";
        $star->Notify("Constelação", $content);

        header("location: ".self::$root_relative_path."/consts.php");
        return true;
    }

    public static function JoinDate($star, $const) {
        if (!is_numeric($const))
            $const = -1;
        if (!is_numeric($star))
            $star = -1;

        if (!Constellation::Exists($const) || empty($const) || !Star::Exists($star) || empty($star)) {
            return false;
        }
        $constellation = new Constellation($const);
        if (!$constellation->ContainsStar($star))
            return false;

        $connection = InformationEntity::GetConnection();
        if (mysqli_affected_rows($connection))
            return false;
        $result = mysqli_query($connection, "select date from star_in_const where const = $const and star = $star ");
        if (is_bool($result))
            return false;
        $date = (mysqli_fetch_array($result, MYSQLI_ASSOC))["date"];
        mysqli_close($connection);
        return $date;
    }

    public static function UpdateProfilePicture($picture) {
        if (!is_array($picture)) {
            $msg = "Ficheiro Inválido!";
            header("location: ".self::$root_relative_path."/updatepic.php?msg=$msg");
            return false;
        } 

        if($picture["size"] == 0) {
            $msg = "Ficheiro vazio!";
            header("location: ".self::$root_relative_path."/updatepic.php?msg=$msg");
            return false;
        }

        if($picture["size"] > 2097152) {
            $msg = "Ficheiro muito pesado!";
            header("location: ".self::$root_relative_path."/updatepic.php?msg=$msg");
            return false;
        }
       

        if($picture["type"] != "image/jpeg" && $picture["type"] != "image/png"){
            $msg = "Formato não suportado!";
            header("location: ".self::$root_relative_path."/updatepic.php?msg=$msg");
            return false;
        }
        
        $target_dir = self::$root_relative_path."/images/stars/star" . Star::MyStar()->GetId();
        $picture_path = $target_dir . "/" . $picture["name"];
        $old_picture_path = $target_dir . "/" . Star::MyStar()->GetImageName();

        if (move_uploaded_file($picture["tmp_name"], $picture_path) && Star::MyStar()->AlterImageName($picture["name"])) {
            unlink($old_picture_path);
            $content = "Alteraste a foto de perfil da tua estrela. <a href='profile.php' class='link-simple'>Consulte</a>.";
            Star::MyStar()->Notify("Foto de perfil", $content);
            $msg = "Acabaste de alterar a foto da tua estrela.";
            header("location: ".self::$root_relative_path."/updatepic.php?msg=$msg");
        } else {
            $msg = "Ocorreu um erro durante a atualização da foto!";
            header("location: ".self::$root_relative_path."/updatepic.php?msg=$msg");
            return false;
        }

        return true;
    }

}
