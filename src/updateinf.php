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
    <title>SPACE - ALTERAR DADOS DA MINNHA ESTRELA</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width" />
</head>

<body>
    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->

    <section class="section-information">
        <?php if (!empty($msg)) {
            echo $msg;
        } else {
            echo "A alteração dos dados é irreversível";
        }
        ?>

    </section>

    <main style="padding: 10px">
        <form name="form_update" class="width-all" action="lib/intermediates/post_intermediate.php" method="post">
            <fieldset class="container-fieldset" style="line-height: 30px;width:100%;">
                <label for="txt_current_password">Palavra passe actual </label><br />
                <input autofocus type="password" class="textbox-update" id="txt_current_password" name="current_password" required minlength="4" maxlength="6" /><br /><br />
                <div style="padding:10px;text-align:left;border-top: 2px solid var(--spacetransparentblue);color: #7c8082">
                    Para que alterar os teus dados, é necessário a tua palavra-passe
                </div>
            </fieldset>
            <fieldset class="container-fieldset" style="line-height: 30px;width: 100%;">
                <label for="txt_name">Novo nome </label><br />
                <input type="text" class="textbox-update" id="txt_name" name="new_name" minlength="4" maxlength="10" value="<?= Star::MyStar()->GetName(); ?>" /><br />
                <label for="txt_password">Nova palavra-passe </label><br />
                <input type="hidden" name="command" value="update_inf" />
                <input type="text" class="textbox-update" id="txt_password" name="new_password" minlength="4" maxlength="6" /><br />
                <label for="txt_description">Nova descrição da estrela</label><br />
                <textarea rows="5" class="textarea-update" id="txt_description" name="new_description" maxlength="255"><?= Star::MyStar()->GetDescription(); ?></textarea><br />
                <div style="padding:10px;text-align:left;border-top: 2px solid var(--spacetransparentblue);color: #7c8082">
                    Somente os campos que sofreram alteração irão mudar
                </div>
                <div class="align-right">
                    <input class="button-update" type="submit" value="Alterar Dados" />
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