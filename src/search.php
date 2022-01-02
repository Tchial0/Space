<?php
//---------------- Space Library ------------
namespace Space;

include_once("lib/spacelibrary.php");
//-------------------------------------------

if (!Star::OnSpace()) {
    $msg = "Acesse primeiro a tua estrela para pesquisares outras estrelas!";
    header("location: login.php?msg=$msg");
    exit();
}

$search_content = $_GET["search_content"] ?? "";
$search = $_GET["search"] ?? "star";
if ($search != "star" && $search != "const")
    $search = "star";
?>

<!DOCTYPE html>
<html>

<head lang="pt-PT">
    <title>SPACE - PESQUISA</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width" />
</head>

<body>

    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->

    <section class="section-information">
        <form action="search.php" method="get" class="form-search">
            <select name="search">
                <option value="star">Estrela</option>
                <option value="const">Constelação</option>
            </select>
            <input autofocus <?php if (!empty($search_content)) echo "value='$search_content'"; ?> placeholder="Pesquise alguma coisa" required name="search_content" type="search" class="textbox-search" />
        </form>
        <br />
        <div style="text-align:right;">
            <?php
            if (!empty($search_content)) {
                if ($search == "star") {
                    echo "Pesquisando por estrelas";
                } else {
                    echo "Pesquisando por constelações";
                }
            }
            ?>
        </div>
    </section>



    <!-- Search Results -->
    <main class="padding-vertical">
        <?php
        $search_count = 0; //For scope reasons
        $range = 5; //The number of results to present for each page
        $start_index = (isset($_GET["start_index"])) ? $_GET["start_index"] : 0; //The index to start from

        if (empty($search_content)) { ?>
            <h4 class="centered">Sem conteúdo para pesquisar...</h4>
            <div class="centered">
                Pesquise por <b>_</b> e vê o que acontece!
            </div>
        <?php } else {
            if ($search == "star") {
                include("lib/embeds/search_stars.php");
            } else {
                include("lib/embeds/search_consts.php");
            }
        }
        ?>
    </main>
    <!-- Search Results -->

    <section class="section-see-more">
        <?php
        if ($search_count > 0) {
            if (($start_index + $range) < $search_count) {
                $index = $start_index + $range;
                echo "<a  class='link-simple'  href=search.php?search_content=$search_content&start_index=$index&search=$search>Próximo</a>";
            }

            if (($start_index > 0)) {
                $index = $start_index - $range;
                echo "<a  class='link-simple'  href=search.php?search_content=$search_content&start_index=$index&search=$search>Anterior</a>";
            }
        }
        ?>
    </section>

    <footer>
        <?php include("lib/embeds/copyright.php"); ?>
    </footer>
</body>

</html>