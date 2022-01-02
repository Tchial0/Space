<?php
//---------------- Space Library ------------
namespace Space;

include_once("lib/spacelibrary.php");
//-------------------------------------------

if (!Star::OnSpace()) {
    $msg = "Acesse a tua estrela para entrares no Space.";
    header("location: login.php?msg=$msg");
    exit();
}
?>

<!DOCTYPE html>
<html  lang="pt-PT">

<head>
    <title>SPACE - PÁGINA INICIAL</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width, initial-scale = 1.0" />
</head>

<body>

    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->

    <main >
        <h2 class="centered">A página inicial ainda está a ser pensada.</h2>
        <h3 class="centered">Tem uma ideia? <a href="mailto:tchialo.crocodile@gmail.com" class="link-simple">Contacte o criador do Space.</a></h3>
    </main>
    <!-- Footer -->
    <footer>
        <?php include("lib/embeds/copyright.php"); ?>
    </footer>
    <!-- Footer -->
</body>

</html>