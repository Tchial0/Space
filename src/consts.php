<?php
//---------------- Space Library ------------

namespace Space;

include_once("lib/spacelibrary.php");
//-------------------------------------------

if (!Star::OnSpace()) {
    $msg = "Faça o login para veres as tuas constelações!";
    header("location: login.php?msg=$msg");
    exit();
}

$msg = (isset($_GET["msg"])) ? $_GET["msg"] : "";
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <title>SPACE - CONSTELAÇÕES</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
</head>

<body>
    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->

    <section class="section-information">
            <span>Você está inserido em (<?= Star::MyStar()->ConstellationsCount(); ?>) constelações</span>
            <?php if (Star::MyStar()->ConstellationsCount() < 1) { ?>
                <div>
                    <p> <b class="link-star">@<?= Star::MyStar()->GetName(); ?></b> insere-te em pelo menos uma constelação para poderes postar e comentar. </p>
                    <p> Precisa de ajuda para encontrar uma constelação para a sua estrela? Fácil! <a class="link-simple" href="search.php?search=const&search_content=_">Clique aqui.</a></p>
                    <p>Se ainda não sabes o que é uma constelação, então <a class="link-simple" href="about.php#constellation">leia sobre isso</a> agora mesmo.</p>
                </div>
            <?php } ?>
    </section>


    <main class="padding-vertical">
        <?php include("lib/embeds/star_consts.php"); ?>

        <section class="section-see-more">
            <?php
            if ($consts_count > $range) {
                if ($start_index > 0) {
                    $previous = $start_index - $range;
                    if ($previous < 0)
                        $previous = 0;
                    echo "<a  class='link-simple'  href='consts.php?start_index=$previous'>Anterior</a>";
                }
                if ($start_index < $default_start_index) {
                    $next = $start_index + $range;
                    if ($next > $consts_count)
                        $next = $default_start_index;
                    echo "<a  class='link-simple'  href='constellation.php?start_index=$next'>Próximo</a>";
                }
            }
            ?>
        </section>
    </main>

    <footer>
        <?php include("lib/embeds/copyright.php"); ?>
    </footer>
</body>

</html>