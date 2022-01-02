<?php namespace Space; ?>
<div class="star">
    <table class="table-star" >
        <tbody >
             <tr >
                <td rowspan="4"  style="width: 80px;">
                    <img alt="Space" style="border-radius: 100%;" src="<?= "images/stars/star" . $star->GetId() . "/" . $star->GetImageName(); ?>" width="70px" />
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px">
                    <b><a class="link-star" href="profile.php?star=<?= $star->GetId(); ?>">@<?= $star->GetName(); ?></a></b>
                </td>
            </tr>
            <tr><td><hr class="no-margin" color="#0e0e0e" size="1px"/></td></tr>
            <tr>
                <td style="padding-left: 10px"><span style="font-size: 11px;">Membro desde (<?= Intermediary::JoinDate($star->GetId(), $const); ?>)</span></td>
            </tr>
        </tbody>
    </table>
</div>