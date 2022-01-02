<?php
//---------------- Space Library ------------
namespace Space;

include_once("lib/spacelibrary.php");
//-------------------------------------------

if (!Star::OnSpace()) {
    $msg = "Faça o login para veres o perfil das estrelas!";
    header("location: login.php?msg=$msg");
    exit();
}

$star_id = $_GET["star"] ?? Star::MyStar()->GetId();

if (!is_numeric($star_id)) {

    $star_id = Star::MyStar()->GetId();
} else if (!Star::Exists($star_id)) {

    $star_id = Star::MyStar()->GetId();
}
$star = new Star($star_id);
?>

<!DOCTYPE html>
<html>

<head lang="pt-PT">
    <title>SPACE - <?= $star->GetName(); ?></title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width" />
</head>

<body>
    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->

    <section class="section-information">
        <div class="container-aboutp">
            <table class="width-all">
                <tr>
                    <td rowspan="3" width="85px"> <a target="_blank" href="<?= "images/stars/star" . $star->GetId() . "/" . $star->GetImageName(); ?>">
                            <img alt="Space" style="border-radius: 100%;" src="<?= "images/stars/star" . $star->GetId() . "/" . $star->GetImageName(); ?>" width="75px" height="75px" />
                        </a>
                    </td>
                </tr>
                <tr>
                    <td>
                        <strong class="link-star">@<?= $star->GetName(); ?></strong>
                        <hr color="dimgray" size="2px" />
                    </td>
                </tr>
                <tr>
                    <td colspan="2" class="align-right">
                        <span class="text-description-star break-words">
                            <?= str_replace("\n", "<br/>", $star->GetDescription()); ?>
                        </span>
                    </td>
                </tr>
            </table>
        </div>
    </section>

    <main  style="padding: 10px">
        <div>
            <div class="container-aboutp">
            <h4 class="no-margin">Sobre</h4>
            <hr color='#0e0e0e' size='1px' />
                <?php
                echo "<b>Nome da estrela:</b> " . $star->GetName() . "<br/>";
                echo "<b>Entrou no Space em:</b> " . (mb_split("-", $star->GetBirth()))[2];
                echo "/" . (mb_split("-", $star->GetBirth()))[1];
                echo "/" . (mb_split("-", $star->GetBirth()))[0] . "<br/>";
                echo "<b>Número de posts: </b>" . $star->PostsCount() . "<br/>";
                echo "<b>Número de comentários: </b>" . $star->CommentariesCount() . "<br/>";
                echo "<b>Está inserida em </b>" . $star->ConstellationsCount() . " constelação(es)<br/>";
                ?>
            </div><br/>
            <?php if ($star->GetId() == Star::MyStar()->GetId()) { ?>
                <div class="padding-vertical centered" style="background-color: rgba(245, 245, 245, 0.1);border-radius: 10px;">Estes são os dados da tua estrela, podes <a href="updateinf.php" class="link-simple">alterá-los.</a></div>
            <?php } ?>
        </div>
    </main>

    <!-- Footer -->
    <footer>
        <?php include("lib/embeds/copyright.php"); ?>
    </footer>
    <!-- Footer -->
</body>

</html>