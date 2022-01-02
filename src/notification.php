<?php
//---------------- Space Library ------------
namespace Space;

include_once("lib/spacelibrary.php");
//-------------------------------------------

if (!Star::OnSpace()) {
    $msg = "Acesse a tua estrela para veres as tuas notificações!";
    header("location: login.php?msg=$msg");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head >
    <title>SPACE - NOTIFICAÇÕES</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width" />
</head>

<body>
    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->

    <?php
    $notifications = Star::MyStar()->GetNotifications();
    $notifications_count = Star::MyStar()->NotificationsCount();
    ?>

    <section class="section-information">A tua estrela tem (<?= $notifications_count; ?>) notificações</section>

    <main>
        <?php
        $nots_range = 5; //The number of notifications to present for each page
        $nots_start_index = (isset($_GET["nots_start_index"])) ? $_GET["nots_start_index"] : 0; //The index from where to start

        if ($notifications_count < 1) {
        ?> <h3 class="centered">Sem notificações!</h3>

        <?php }
        include("lib/embeds/star_nots.php"); ?>


        <section class="section-see-more">
            <?php
            if (($nots_start_index + $nots_range) < $notifications_count) {
                $previous = $nots_start_index + $nots_range;
                echo "<a  class='link-simple'  href=notification.php?start_index=$previous>+Antigo</a>";
            }

            if ($nots_start_index > 0) {
                $next = $nots_start_index - $nots_range;
                echo "<a  class='link-simple'  href=notification.php?start_index=$next>+Recente</a>";
            }
            ?>
        </section>

        <div class="padding-vertical">
            <ul class="ul-footer" style="text-align:left;">
                <li><a class="link-formed" href='lib/intermediates/get_intermediate.php?command=delete_not_all'>Limpar Notificações</a></li>
            </ul>
        </div>
    </main>

    <footer>
        <?php include("lib/embeds/copyright.php"); ?>
    </footer>
</body>

</html>