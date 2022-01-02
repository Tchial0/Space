<?php

namespace Space;

include_once("lib/spacelibrary.php");

if (!Star::OnSpace()) {
    $msg = "Faça o login para alterar os teus dados!";
    header("location: login.php?msg=$msg");
    exit();
}

$msg =  $_GET["msg"] ?? "";
?>

<!DOCTYPE html>
<html>

<head lang="pt-PT">
    <title>SPACE - ALTERAR FOTO DE PERFIL</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->

    <section class="section-information">
        <div >
            <?php if (!empty($msg)) {
                echo $msg;
            } else {
                echo "A foto de perfil antiga será eliminada.";
            }
            ?>
        </div>
    </section>

    <main style="padding: 10px">
        <form enctype="multipart/form-data" action="lib/intermediates/post_intermediate.php" method="post">
            <fieldset class="container-fieldset" style="line-height: 35px;width: 100%;">
                <input type="hidden" name="command" value="update_pic" />
                <label for="txt_file">Nova foto de perfil</label><br />
                <input filter=".png" autofocus type="file" class="textbox-update" id="txt_file" name="picture" required /><br /><br />
                <div style="padding:10px;text-align:left;border-top: 2px solid var(--spacetransparentblue);color: #7c8082">
                    Formatos suportados: png, jpeg, jpg.
                </div>
                <div class="align-right">
                    <input class="button-update" type="submit" value="Alterar Foto" />
                </div>
            </fieldset>
        </form>
    </main>

    <footer>
        <?php include("lib/embeds/copyright.php"); ?>
    </footer>
</body>

</html>

<script type="text/javascript">
    form_update.onsubmit = function() {

        return confirm("Pretente proseguir com a alteração?");
    };
</script>