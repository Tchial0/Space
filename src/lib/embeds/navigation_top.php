<?php namespace Space; ?>

<li class="highlightable" title="Página Inicial">
    <a href="home.php">
        <img src="images/interface/home.svg">
    </a>
</li>
<li class="highlightable" title="Minha Estrela">
    <a href="profile.php">
        <img src="images/interface/star_filled.svg">
    </a>
</li>
<li class="highlightable" title="Minhas Constelações">
    <a href="consts.php">
        <img src="images/interface/star_of_david.svg">
    </a>
</li>
<li class="highlightable" title="Notificações" style="position:relative;">
<?php
    $uncount = Star::MyStar()->UNotsCount();
    if ($uncount > 0) {
    ?> <div class="space-bubble"><?= $uncount; ?></div>
    <?php } ?>
    <a href="notification.php" >
        <img src="images/interface/notification.svg">
    </a>
</li>
<li class="highlightable" title="Pesquisa">
    <a href="search.php">
        <img src="images/interface/search.svg">
    </a>
</li>
<li class="highlightable" style="float: right;" title="Menu">
    <a style="cursor:pointer;" onclick="show_menu()">
        <img src="images/interface/menu.svg" />
    </a>
</li>