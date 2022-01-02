<?php namespace Space; ?>
<div style="margin-top: 10px;">
    <table class="table-notification" cellpadding="4" cellspacing="0">
        <thead>
            <tr>
                <th class="align-left"><?= $notification->GetTitle(); ?></th>
                <th class="align-right" style="font-size: 10px;">
                    <a class="link-simple" href="lib/intermediates/get_intermediate.php?command=delete_not&id=<?= $notification->GetId(); ?>">Eliminar</a>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="2"><span class='content-notification'><?= str_replace("\n", "<br/>", $notification->GetContent()); ?></span></td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td align="left">
                    <?php
                    if ($notification->Seen() == '1') {
                        echo "<img title='Vista' src='images/interface/filled_circle.svg' width='12px'>";
                    } else {
                        echo "<img title='Não vista' src='images/interface/unfilled_circle.svg' width='12px'>";
                        $notification->MarkAsRead();
                    }
                    ?>
                </td>
                <td width="60%" align="right" style="font-size: 10px; color: gray;">
                    <?php echo $notification->GetDate() . ", " . $notification->GetTime(); ?>
                </td>
            </tr>
        </tfoot>
    </table>
</div>