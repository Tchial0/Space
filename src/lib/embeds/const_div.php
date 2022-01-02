<?php
namespace Space;
?>

<div class="constellation">
    <?php
    if (!isset($constellation)) {
        echo "<div class='container-aboutp'>Erro de script: constelação não definida.</div>";
    } else {
        if (!Constellation::Exists($constellation->GetId())) {
            echo "<div class='container-aboutp'>Erro de script: constelação inexistente.</div>";
        } else { ?>
            <table class="width-all" >
                    <tr>
                        <td rowspan="4" class="container-profile-image">
                            <img src="<?= "images/consts/const" . $constellation->GetId() . "/" . $constellation->GetImageName(); ?>" width="50px" />
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left: 10px">
                            <b><a class="link-form" href="constellation.php?const=<?= $constellation->GetId(); ?>"><?= $constellation->GetName(); ?></a></b>
                        </td>
                        <td align="right">
                            <?php
                            if ($constellation->ContainsStar(Star::MyStar()->GetId())) {
                                $joindate = Intermediary::JoinDate(Star::MyStar()->GetId(), $constellation->GetId());
                                echo "<small>inserido ($joindate)</small>";
                            } else {
                                $const = $constellation->GetId();
                                echo "<small><a class='link-simple' href='lib/intermediates/get_intermediate.php?command=join_const&const=$const'>Entrar</a></small>";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <td colspan="2">
                            <hr class="no-margin" color="#0e0e0e" size="1px" />
                        </td>
                    </tr>
                    <tr>
                        <td style="padding-left: 10px">
                            <small>Proprietário: <b><?php if ($constellation->HasOwner()) {
                                                        echo "<a href='#'>" . $constellation->GetOwner()->GetName() . "</a>";
                                                    } else {
                                                        echo "Space";
                                                    } ?></b> (<?= $constellation->GetDate(); ?>) </small>
                        </td>
                        <td class="align-right">
                            <small>Membros (<?= $constellation->MembersCount(); ?>)</small>
                        </td>
                    </tr>
            </table>
            <div>
                <p style="padding: 8px;color:dimgray;">
                    <?= $constellation->GetDescription(); ?>
                </p>
            </div>
    <?php }
    } ?>
</div>