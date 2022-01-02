<?php
//---------------- Space Library ------------
namespace Space;
include_once("lib/spacelibrary.php");
//-------------------------------------------

if (!Star::OnSpace()) {
    header("location: login.php");
} else {
    if (isset($_GET["cmd"])) {
        if ($_GET["cmd"] == "log_out") {
            Star::LogOut();
            header("location: login.php");
        } else {
            header("location: login.php");
        }
    } else {
        header("location: home.php");
    }
}
?>