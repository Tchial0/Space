<?php
//---------------- Space Library ------------
namespace Space;
include_once("lib/spacelibrary.php");
//-------------------------------------------

if (!Star::OnSpace()) {
    $msg = "Tens de acessar a tua estrela!";
    header("location: login.php?msg=$msg");
    exit();
}

$commentid = $_GET["comment"] ?? -1;
if (!Commentary::Exists($commentid)) {
    $msg = "Comentário não identificado";
    header("location: error.php?msg=$msg");
    exit();
}
$commentary = new Commentary($commentid);
if ($commentary->GetOwner()->GetId() != Star::MyStar()->GetId()) {
    $msg = "Acesso negado!";
    header("location: error.php?msg=$msg");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <title>SPACE - EDITAR COMENTÁRIO</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->

    <section class="container-aboutp">
        <div class="container-aboutp">Pense bem antes de alter este comentário, pois nenhuma estrela será notificada desta alteração.</div>
    </section>
   
    <main style="padding: 10px;">
        <form action="lib/intermediates/post_intermediate.php" method="post">
            <input type="hidden" name="command" value="edit_commentary" />
            <input type="hidden" name="comment" value="<?= $commentid ?>" />
            <fieldset class="container-fieldset" style="width: 100%;">
                <div style="padding:5px;text-align:left;border-bottom: 2px solid var(--spacetransparentblue);color: #7c8082">
                    <span>
                        <?php
                        $const = $commentary->GetPost()->GetConstellation()->GetId();
                        echo "Comentário de <a class='link-star' href='profile.php'>@" . $commentary->GetOwner()->GetName() . "</a> em <a class='link-form' href='constellation.php?const=$const'>" . $commentary->GetPost()->GetConstellation()->GetName() . "</a>";
                        echo " | " . $commentary->GetDate() . ", " . $commentary->GetTime();
                        ?>
                    </span>
                </div>
                <br />
                <div>
                    <textarea required autofocus class="textarea-comment" name="content" id="txt_content"><?php echo $commentary->GetRawContent(); ?></textarea>
                </div>
                <br />
                <div style="padding:10px;text-align:left;border-top: 2px solid var(--spacetransparentblue);color: #7c8082">
                    Edição de comentário...
                </div>
                <div class="align-right">
                    <input class="button-update" type="submit" value="Editar" />
                </div>
            </fieldset>
        </form>
    </main>

    <footer>
        <?php include("lib/embeds/copyright.php"); ?>
    </footer>
   
</body>

</html>