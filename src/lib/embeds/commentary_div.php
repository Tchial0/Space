<?php

namespace Space; ?>
<div class="commentary">
    <table class="width-all" cellpadding="4">
        <thead>
            <tr>
                <th align="left">
                    <?= "<a class='link-star'><small>@" . $commentary->GetOwner()->GetName() . "</small></a>"; ?>
                </th>
                <?php
                if ($commentary->GetOwner()->GetId() == Star::MyStar()->GetId()) {
                    $commentary_id = $commentary->GetId();
                ?>
                    <th align="right">
                        <a class="link-simple" href="lib/intermediates/get_intermediate.php?command=delete_comment&id=<?= $commentary_id; ?>"><small><sub>Eliminar</sub></small></a>
                        &nbsp;&nbsp;&nbsp;<a href="editcomment.php?comment=<?= $commentary_id; ?>" class="link-simple" href="editcomment.php?comment=<?= $commentary_id; ?>"><small><sub>Editar</sub></small></a>
                    </th>
                <?php
                }
                ?>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2">
                    <div class='content-commentary'>
                        <?php
                        $content = str_replace("\n", "<br/>", $commentary->GetContent());
                        echo $content;
                        ?>
                    </div>
                    <hr size='1px' color='#0e0e0e' />
                </td>
            </tr>
        </tbody>
    </table>
</div>