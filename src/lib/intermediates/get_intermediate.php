<?php
namespace Space;
require_once("../spacelibrary.php");
$root_relative_path = "../..";

if (!Star::OnSpace()) {
    $msg = "Faça o login para entrares no Space!";
    header("location: $root_relative_path/login.php?msg=$msg");
    exit();
}  

$command =  $_GET["command"] ?? "";
$id =  $_GET["id"] ?? "";

switch($command){
    case "delete_post":
        Intermediary::DeletePost($id);
        break;
    case "delete_not":
        Intermediary::DeleteNotification($id);
        break;
    case "delete_not_all":
        Intermediary::ClearMyNotifications();
        break;
    case "delete_comment":
        Intermediary::DeleteCommentary($id);
        break;
    case "join_const":
        $const =  $_GET["const"] ?? "";
        Intermediary::JoinConstellation($const);
        break;
    case "leave_const":
        $const =  $_GET["const"] ?? "";
        Intermediary::LeaveConstellation($const);
        break;
    default :
        $msg = "Commando não identificado";
        header("location: $root_relative_path/error.php?msg=$msg");
        break;
}

?>