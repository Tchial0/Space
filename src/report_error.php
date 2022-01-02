<?php
//---------------- Space Library ------------
namespace Space;

include_once("lib/spacelibrary.php");
//-------------------------------------------

if (!Star::OnSpace()) {
    $msg = "Faça o login para reportares um erro.";
    header("location: login.php?msg=$msg");
    exit();
}

$msg =  $_GET["msg"] ?? "";
?>
<!DOCTYPE html>
<html>

<head lang="pt-PT">
    <title>SPACE - REPORTAR ERRO </title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width" />
</head>

<body>
    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->

    <section class="section-information centered">
    Reporte aqui o erro que encontrou!
    </section>

    <main style="padding: 10px;">
        <form action="lib/intermediates/post_intermediate.php" method="post">
            <input type="hidden" name="command" value="report_error" />
            <fieldset class="container-fieldset" style="width: 100%;">
                <div style="padding:5px;text-align:left;border-bottom: 2px solid var(--spacetransparentblue);color: #7c8082">
                    <?php
                    if (!empty($msg)) {
                        echo $msg;
                    } else {
                        echo "O que aconteceu ?";
                    }
                    ?>
                </div>
                <br />
                <div>
                    <textarea required autofocus placeholder="Escreve alguma coisa..." class="textarea-report" name="error_content" id="error_content"></textarea>
                </div>
                <br />
                <div style="padding:10px;text-align:left;border-top: 2px solid var(--spacetransparentblue);color: #7c8082">
                    Para nos ajudar a resolver o problema, seja o mais claro possível!
                </div>
                <div class="align-right">
                    <input class="button-update" type="submit" value="Reportar erro" />
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
    var form = document.getElementById("form_report");
    form.onsubmit = function() {
        return confirm("Tem a certeza que pretende reportar este erro!");
    }
</script>