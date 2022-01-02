<?php
//---------------- Space Library ------------
namespace Space;

include_once("lib/spacelibrary.php");
//-------------------------------------------

if (!Star::OnSpace()) {
    $msg = "Faça o login para entrares no Space";
    header("location: login.php?msg=$msg");
    exit();
}

$const =  $_GET["const"] ?? -1;
if (!is_numeric($const)) $const = -1;

if (!Constellation::Exists($const)) {
    $msg = "Constelação não identificada";
    header("location: error.php?msg=$msg");
    exit();
}
$constellation = new Constellation($const);

$members = $constellation->GetMembers();
$members_count = $constellation->MembersCount();

$range = 5; //The number of members to present on each page
$start_index = (isset($_GET["start_index"])) ? $_GET["start_index"] : 0; //The index to start from

if ($start_index >= $members_count)
    $start_index = 0; //Verify whether the star_index has surpassed the boundary
if ($range > $members_count)
    $range = $members_count; //Verify whether the range of members to present is greater than the available ones
?>


<!doctype html>
<html lang="pt-PT">

<head>
    <title>SPACE - MEMBROS DE <?= $constellation->GetName(); ?></title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width" />
</head>

<body>
    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->

    <section class="section-information">
        <div style="background-color: rgba(0,0,0,0.5);border-radius: 10px;margin-bottom: 10px;">
            <table>
                <tr>
                    <td><img src="<?= 'images/consts/const' . $const . '/' . $constellation->GetImageName(); ?>"></td>
                    <td> <span>Estrelas de <?= $constellation->GetName() . " ($members_count)"; ?></span></td>
                </tr>
            </table>
        </div>
    </section>

    <main class="padding-vertical">
        <!-- Members -->
        <section>
            <?php
            $row = 0; //Current row of the members' list
            for ($row = $start_index; $row < ($start_index + $range); $row++) {

                if ($row < 0 || $row >= $members_count)
                    break; //Out of the valid indexes
                $star = new Star($members[$row]["id"]);
                include("lib/embeds/const_member_div.php");
            }
            ?>
        </section>
        <!-- Members -->
    </main>
    
    <section class="section-see-more">
            <?php
            if ($members_count > 0) {
                if (($start_index + $range) < $members_count) {
                    $index = $start_index + $range;
                    echo "<a  class='link-simple'  href=members.php?const=$const&start_index=$index>Próximo</a>";
                }

                if (($start_index > 0)) {
                    $index = $start_index - $range;
                    echo "<a  class='link-simple'  href=members.php?const=$const&start_index=$index>Anterior</a>";
                }
            }
            ?>
        </section>

    <footer>
        <?php include("lib/embeds/copyright.php"); ?>
    </footer>
</body>

</html>