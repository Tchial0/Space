<div class="star">
    <table class="table-star" >
        <tbody >
            <tr >
                <td rowspan="4"  >
                    <img alt="Space" style="border-radius: 100%;" src="<?= "images/stars/star" . $star->GetId() . "/" . $star->GetImageName(); ?>" width="70x" height="70px" />
                </td>
            </tr>
            <tr>
                <td style="padding-left: 10px">
                    <b><a class="link-star" href="profile.php?star=<?= $star->GetId(); ?>">@<?= $star->GetName(); ?></a></b>
                </td>
            </tr>
            <tr><td><hr class="no-margin" color="#0e0e0e" size="1px"/></td></tr>
            <tr>
                <td style="padding-left: 10px"><span style="font-size: 11px;">No Space desde (<?= $star->GetBirth(); ?>), inserido em (<?= $star->ConstellationsCount(); ?>) constelação(es)</span></td>
            </tr>
        </tbody>
    </table>
</div>