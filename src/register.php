<?php
//---------------- Space Library ------------
namespace Space;
include_once("lib/spacelibrary.php");
//-------------------------------------------

if (Star::OnSpace()) {
    header("location: home.php");
    exit();
}
$msg =  $_GET["msg"] ?? "";
$star_name =  $_GET["star_name"] ?? "";
?>

<!DOCTYPE html>
<html>

<head lang="pt-PT">
    <title>SPACE - CRIAR ESTRELA</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width" />
    <style type="text/css">
        .anim-scale {
            animation: scale 1s ease infinite normal running;
        }

        @keyframes scale {
            from {
                transform: scale(0);
            }

            to {
                transform: scale(1);
            }
        }
    </style>
</head>

<body>

    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->

    <main style="padding: 10px 0px;">

        <form class="width-all centered" action="lib/intermediates/post_intermediate.php" method="post" id="register_form">
            <input type="hidden" name="command" value="register" />
            <fieldset class="container-fieldset">
                <div style="padding:5px;text-align:left;border-bottom: 2px solid var(--spacetransparentblue);color: #7c8082">
                    <?php
                    if (!empty($msg)) {
                        echo $msg;
                    } else {
                        echo "Preencha os dados da tua nova estrela";
                    }
                    ?>
                </div>
                <div style="padding: 10px;line-height: 40px;">
                    <label for="register_name">Nome da estrela</label>
                    <br />
                    <input <?php
                            if ($star_name != "") {
                                echo "value='$star_name'";
                            }
                            ?> class="textbox-login" id="register_name" name="register_name" type="text" minlength="5" maxlength="15" required autofocus />
                    <br />
                    <label for="register_password">Palavra-passe</label>
                    <br />
                    <input class="textbox-login" id="register_password" name="register_password" type="password" minlength="5" maxlength="10" required />
                </div>
                <div style="padding:10px;text-align:left;border-top: 2px solid var(--spacetransparentblue);color: #7c8082">
                    O nome não pode conter espaços, acentuação ou número. A senha não pode conter espaços. <a class="link-simple" href="about.php#standards">Mais detalhes</a>
                </div>
            </fieldset>

            <fieldset class="container-fieldset">
            <div style="padding:5px;text-align:left;border-bottom: 2px solid var(--spacetransparentblue);color: #7c8082">
                  A princípio, uma constelação será necessária!
                </div>
                <br/>
                <label for="register_const">Constelação</label>
                <br /><br />
                <select id="register_const" class="selection-register" name="register_const" onchange="OnConstImgChange()">
                    <option value="1">CHAMELEON</option>
                    <option value="2">HORSE</option>
                    <option value="3">BIRD</option>
                </select>
                <br />

                <object id="const_img" type="image/svg+xml" data="images/consts/const1/chameleon.svg" width="100px" height="100px">
                    <img src="images/consts/default.png" width="100px" height="100px">
                </object>
                <br />
                <div style="padding:10px;text-align:left;border-top: 2px solid var(--spacetransparentblue);color: #7c8082">
                    Não sabes o que é uma constelação? <a class="link-simple" href="about.php#constellation">Saiba agora.</a>
                </div>
            </fieldset>

            <div style="line-height:40px;">
                <input class="button-login" style="width:45%;" type="submit" value="Criar Estrela" />
                <br />
            </div>
            <div style="line-height:40px;">
                <fieldset style="border:none;border-top: 1px solid var(--spaceblackblue);line-height: 30px;">
                    <legend style="padding: 10px;"> <a class="link-form" href="login.php">Já tenho uma estrela!</a></legend>
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

<script type="text/javascript">
    function OnConstImgChange() {
        if (register_const.value == "1") {
            const_img.data = "images/consts/const1/chameleon.svg";
        } else if (register_const.value == "2") {
            const_img.data = "images/consts/const2/horse.svg";
        } else if (register_const.value == "3") {
            const_img.data = "images/consts/const3/bird.svg";
        }

        const_img.className = "anim-scale";
        setTimeout(function() {
            const_img.className = "";
        }, 1000);

    }
</script>