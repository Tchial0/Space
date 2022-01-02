<?php
//---------------- Space Library ------------
namespace Space;

include_once("lib/spacelibrary.php");
//-------------------------------------------

if (!Star::OnSpace()) {
    $msg = "Faça o login para participares nas constelações.";
    header("location: login.php?msg=$msg");
    exit();
}
$const = $_GET["const"] ?? -1;
if (!is_numeric($const))
    $const = -1;

if (!Constellation::Exists($const)) {
    $msg = "Constelação não identificada";
    header("location: error.php?msg=$msg");
    exit();
}
$constellation = new Constellation($const);
?>

<!DOCTYPE html>
<html lang="pt-PT">

<head>
    <title>SPACE - CONSTELAÇÃO (<?= $constellation->GetName(); ?>)</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width" />
</head>

<body>
    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->

    <!-- Send Post Section -->
    <section class="section-information">
        <div style="background-color: rgba(0,0,0,0.5);border-radius: 10px;margin-bottom: 10px;">
            <table>
                <tr>
                    <td><img src="<?= 'images/consts/const' . $const . '/' . $constellation->GetImageName(); ?>"></td>
                    <td><?= $constellation->GetName(); ?></td>
                </tr>
            </table>
        </div>

        <?php if (!Star::MyStar()->JoinedConst($const)) { ?>
            <div class="container-aboutp" ><span class=link-star>@<?= Star::MyStar()->GetName() ?></span> você não faz parte desta constelação.
            <?php
            $constellation = new Constellation($const);
            if (!$constellation->HasOwner()) {
               
                echo "Porém, esta constelação é permanente, então podes fazer parte dela agora, ";
                echo "<a class='link-form' href='codes/get_intermediate.php?command=join_const&const=$const'> clicando aqui.</a>";
                echo "</div>";
            }
        } else {
            echo "</div>";
            ?>

            <form class="container-aboutp" action="lib/intermediates/post_intermediate.php" method="post">
                <input type="hidden" name="command" value="send_post" />
                <input type="hidden" name="const" value="<?= $const; ?>" />
                <table width="100%">
                    <tr>
                        <td><img alt="Space" style="border-radius: 100%;" src="<?= "images/stars/star" . Star::MyStar()->GetId() . "/" . Star::MyStar()->GetImageName(); ?>" width="50px" height="50px" /></td>
                        <td><textarea placeholder="Esreva para a constelação..." required class="textarea-post" name="content" id="txt_content"></textarea></td>
                        <td><input title="Publicar" class="button-post" type="submit" value="" /></td>
                    </tr>
                </table>
            </form>
        <?php } ?>
    </section>
    <!-- Send Post Section  -->

    <main>
        <!-- Posts -->
        <section>
            <?php include("lib/embeds/const_posts.php"); ?>
        </section>
        <!-- Posts -->

        <!-- See more section -->
        <section class="section-see-more">
            <?php
            if ($posts_count > $posts_range) {
                if ($posts_start_index > 0) {
                    $previous = $posts_start_index - $posts_range;
                    if ($previous < 0)
                        $previous = 0;
                    echo "<a  class='link-simple'  href='constellation.php?const=$const&posts_start_index=$previous'>+ Antigo</a>";
                }

                if ($posts_start_index < $default_posts_start_index) {
                    $next = $posts_start_index + $posts_range;
                    if ($next > $default_posts_start_index)
                        $next = $default_posts_start_index;

                    echo "<a  class='link-simple'  href='constellation.php?const=$const&posts_start_index=$next'>+ Recente</a>";
                }
            }
            ?>
        </section>
        <!-- See more section -->


        <!-- Options -->
        <div class="padding-vertical">
            <ul class="ul-footer" style="text-align:left;">
                <li><a class="link-formed" href='members.php?const=<?= $const; ?>'>Membros</a></li>
                <?php
                if ((new Constellation($const))->ContainsStar(Star::MyStar()->GetId())) {
                ?>
                    <li><a class="link-formed" href='lib/intermediates/get_intermediate.php?command=leave_const&const=<?= $const; ?>'>Sair deste constelação</a></li>
                <?php } ?>
            </ul>
        </div>
        <!-- Options -->
    </main>
    <!-- Footer -->
    <footer>
        <?php include("lib/embeds/copyright.php"); ?>
    </footer>
    <!-- Footer -->
</body>

</html>

<script type="text/javascript">
    function View_Post_Commentaries(post_id) {
        var commentaries_div = document.getElementById(post_id.toString() + "_commentaries_div");

        if (commentaries_div != null) {
            if (commentaries_div.style.display) {
                if (commentaries_div.style.display == "none") {
                    commentaries_div.style.display = "block";
                } else {
                    commentaries_div.style.display = "none";
                }

            } else {
                commentaries_div.style.display = "none";
            }
        }

        var commentary_form = document.getElementById(post_id.toString() + "_commentary_form");
        if (commentary_form.style.display) {
            if (commentary_form.style.display == "none") {
                commentary_form.style.display = "block";
            } else {
                commentary_form.style.display = "none";
            }

        } else {
            commentary_form.style.display = "none";
        }
    }
</script>