<?php

namespace Space; ?>

<header class="header-space">
    <?php
    if (!Star::OnSpace()) { ?>
        <div style="float:right;padding:20px;color:gray">Um lugar para as estrelas!</div>
    <?php
    }
    ?>
    <ul class="ul-header-home">
        <li>
            <?php if (Star::OnSpace()) { ?>
                <a class="link-simple" href="index.php"><b style="font-size: 1.5em;">S</b></a>
            <?php } else { ?>
                <a class="link-simple" href="index.php"><b style="font-size: 1.8em;">Space</b></a>
            <?php } ?>
        </li>
        <?php if (Star::OnSpace()) include("navigation_top.php");
        ?>
    </ul>

    <div class="space-dropdown">
        <div id="menu_dropdown" class="dropdown-content">
            <a href='updateinf.php'>Alterar dados da minha estrela</a>
            <a href='updatepic.php'>Alterar foto de perfil</a>
            <a href='#'>Criar minha constelação</a>
            <hr color="#0e0e0e" size="1px" class="no-margin" />
            <a href='report_error.php'>Reportar Erro</a>
            <a href='mailto:tchialo.crocodile@gmail.com?Subject=Space'>Contactar Programador (e-mail)</a>
            <a href='about.php'>Sobre o Space</a>
            <hr color="#0e0e0e" size="1px" class="no-margin" />
            <a href='index.php?cmd=log_out'>Sair do Space</a>
        </div>
    </div>
</header>

<script>
    function show_menu() {
        if (menu_dropdown.style.display != "block") {
            menu_dropdown.style.display = "block";
        } else {
            menu_dropdown.style.display = "none";
        }
    }
</script>