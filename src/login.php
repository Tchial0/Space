<?php
//---------------- Space Library ------------
namespace Space;

include_once("lib/spacelibrary.php");
//-------------------------------------------

if (Star::OnSpace()) {
    header("location: home.php");
    exit();
}

$msg = $_GET["msg"] ?? "";
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head >
    <title>SPACE - LOGIN </title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width" />
</head>

<body>
    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->

    <main style="padding: 10px 0px;">
        <form class="width-all centered" action="lib/intermediates/post_intermediate.php" method="post" name="form_login">
            <input type="hidden" name="command" value="login" />
            <fieldset class="container-fieldset">
                <div style="padding:5px;text-align:left;border-bottom: 2px solid var(--spacetransparentblue);color: #7c8082">
                    <?php
                    if (!empty($msg)) {
                        echo $msg;
                    } else {
                        echo "Faça o login com os dados da tua estrela";
                    }
                    ?>
                </div>
                <div style="padding: 10px;line-height: 40px;">
                    <label for="loign_name">Nome da estrela</label>
                    <br />
                    <input autofocus class="textbox-login" id="login_name" name="login_name" type="text" minlength="5" maxlength="15" required />
                    <br />
                    <label for="login_password">Palavra-passe</label>
                    <br />
                    <input class="textbox-login" id="login_password" name="login_password" type="password" minlength="5" maxlength="10" required />
                    <br /><br />
                </div>
                <div style="padding:10px;text-align:left;border-top: 2px solid var(--spacetransparentblue);color: #7c8082">
                    <a style="float:left;" class="link-simple width-all-insc padding-vertical" onclick="alert('Opção indisponível! Para mais informações, consulte o desenvolvedor do Space.');">Esqueceu a palavra-passe?</a>
                    <input class="button-login width-all-insc padding-vertical" style="float:right;" type="submit" value="Entrar" />
                </div>
            </fieldset>
            <div style="line-height:40px;">
                <fieldset style="border:none;border-top: 1px solid var(--spaceblackblue);line-height: 30px;">
                    <legend style="padding: 20px;">Se ainda não tens uma estrela no Space</legend>
                    <a class="link-green" href="register.php">Crie uma estrela agora!</a>
                </fieldset>
            </div>
        </form>

    </main>

    <footer>
        <?php include("lib/embeds/navigation_bottom.php") ?>
        <?php include("lib/embeds/copyright.php"); ?>
    </footer>
</body>

</html>