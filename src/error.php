<?php
namespace Space;
include_once("lib/spacelibrary.php");
?>

<!DOCTYPE html>
<html lang="pt-PT">
    <head>
        <title>SPACE - ERRO</title>
        <meta charset="UTF-8" />
        <link rel="stylesheet" href="styles/style.css" />
        <meta name="viewport" content="width=device-width, initial-scale = 1.0" />
    </head>

    <body>

        <!-- Header -->    
<?php include("lib/embeds/header.php"); ?>
        <!-- Header -->
        
        <main>
            <h4 class="centered">Lamentamos, mas ocorreu um erro!</h4>
            <div class="container-content centered" style="color: red;">
                <?php
                   $msg = $_GET["msg"] ?? "";
                   if(!empty($msg)) echo $msg;
                ?>
            </div>
        </main>
        <!-- Footer -->
        <footer>
<?php include("lib/embeds/copyright.php"); ?>
        </footer>
        <!-- Footer -->
    </body>
</html>



