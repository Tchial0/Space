<?php
namespace Space;
require_once("../spacelibrary.php");
$root_relative_path = "../..";

$command =  $_POST["command"] ?? "";

switch ($command) {

    case "register":
        $name =  $_POST["register_name"] ?? "";
        $password =  $_POST["register_password"] ?? "";
        $const = $_POST["register_const"] ?? -1;

        if (Intermediary::RegisterStar($name, $password)) {
            $star_id = Star::GetStarID($name);
           
            if (Star::LogIn($star_id)) {
                if(!is_numeric($const)) $const = -1;
                if(Constellation::Exists($const)){
                    $constellation = new Constellation($const);
                    if(!$constellation->HasOwner()){
                        $constellation->AddStar($star_id);
                    }
                }
                
                header("location: $root_relative_path/home.php");
            } else {
                $msg = "Erro: Não foi possível fazer o login!";
                header("location: $root_relative_path/login.php?msg=$msg");
            }
        }

        break;

    case "login":
        $name =  $_POST["login_name"] ?? "";
        $password =  $_POST["login_password"] ?? "";
        Intermediary::Login($name, $password);
        break;

    case "send_post":
        $const =  $_POST["const"] ?? -1;
        $content = (isset($_POST["content"])) ? trim($_POST["content"]) : "";
        Intermediary::SendPost($const,$content);
        break;

    case "update_inf":
        $current_password =  $_POST["current_password"] ?? "";
        $new_name =   $_POST["new_name"] ?? "";
        $new_password =  $_POST["new_password"] ?? "";
        $new_description =  $_POST["new_description"] ?? "";
        $new_description = trim($new_description);
        Intermediary::UpdateInformations($current_password, $new_name, $new_password, $new_description);
        break;

    case "send_commentary":
        $postid =  $_POST["postid"] ?? "";
        $content = (isset($_POST["content"])) ? trim($_POST["content"]) : "";
        Intermediary::SendCommentary($postid, $content);
        break;

    case "report_error":
        $content =  $_POST["error_content"] ?? "";
        $content = trim($content);
        Intermediary::ReportError($content);
        break;
    case "update_pic":
        $picture = $_FILES["picture"] ?? "";
        Intermediary::UpdateProfilePicture($picture);
        break;
    case "edit_post":
        $postid = $_POST["post"] ?? "";
        $content = $_POST["content"] ?? "";
        $content = trim($content);
        Intermediary::EditPost($postid, $content);
        break;
    case "edit_commentary":
            $commentid = $_POST["comment"] ?? -1;
            $content = $_POST["content"] ?? "";
            $content = trim($content);
            Intermediary::EditCommentary($commentid,$content);
            break;    
    default:
        $msg = "Nenhum comando recebido!";
        header("location: $root_relative_path/error.php?msg=$msg");
        break;
}
?>