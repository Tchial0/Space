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

$postid = $_GET["post"] ?? -1;
if (!is_numeric($postid))
    $postid = -1;
if (!Post::Exists($postid)) {
    $msg = "Post não identificado";
    header("location: error.php?msg=$msg");
    exit();
}
$post = new Post($postid);
if ($post->GetOwner()->GetId() != Star::MyStar()->GetId()) {
    $msg = "Acesso negado";
    header("location: error.php?msg=$msg");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <title>SPACE - EDITAR POST</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->

    <section class="section-information">
        <div class="container-aboutp">Pense bem antes de alter este post, pois nenhuma estrela será notificada desta alteração.</div>
    </section>
   
    <main style="padding:10px;">
        <form action="lib/intermediates/post_intermediate.php" method="post">
            <input type="hidden" name="command" value="edit_post" />
            <input type="hidden" name="post" value="<?= $postid ?>" />
            <fieldset class="container-fieldset" style="width: 100%;">
                <div style="padding:5px;text-align:left;border-bottom: 2px solid var(--spacetransparentblue);color: #7c8082">
                    <span>
                        <?php
                        $const = $post->GetConstellation()->GetId();
                        echo "Post de <a class='link-star' href='profile.php'>@" . $post->GetOwner()->GetName() . "</a> em <a class='link-form' href='constellation.php?const=$const'>" . $post->GetConstellation()->GetName() . "</a>";
                        echo " | " . $post->GetDate() . ", " . $post->GetTime();
                        ?>
                    </span>
                </div>
                <br />
                <div>
                    <textarea required autofocus class="textarea-post" name="content" id="txt_content"><?php echo $post->GetRawContent(); ?></textarea>
                </div>
                <br />
                <div style="padding:10px;text-align:left;border-top: 2px solid var(--spacetransparentblue);color: #7c8082">
                    Número de comentário(s): <?= $post->CommentariesCount(); ?>
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