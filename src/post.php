<?php
//---------------- Space Library ------------
namespace Space;

include_once("lib/spacelibrary.php");
//-------------------------------------------

if (!Star::OnSpace()) {
    $msg = "Tens de acessar a tua estrela!";
    header("location: login.php?msg=$msg");
    exit();
}

$postid = $_GET["post"] ?? -1;
if (!is_numeric($postid))
    $postid = -1;
if (!Post::Exists($postid)) {
    $msg = "Post não identificado";
    header("location: error.php?msg=$msg");
    exit();
}
$post = new Post($postid);
?>

<!DOCTYPE html>
<html>

<head lang="pt-PT">
    <title>SPACE - POST</title>
    <meta charset="UTF-8" />
    <link rel="stylesheet" href="styles/style.css" />
    <meta name="viewport" content="width=device-width" />
</head>

<body>
    <!-- Header -->
    <?php include("lib/embeds/header.php"); ?>
    <!-- Header -->


    <!-- Post Header -->
    <section>
        <div class="padding-vertical">
            <span style="margin-left: 1em;"><small>
                    <?php
                    $const = $post->GetConstellation()->GetId();
                    echo "@" . $post->GetOwner()->GetName() . " > <a class='link-form' href='constellation.php?const=$const'>" . $post->GetConstellation()->GetName() . "</a>";
                    if (Star::MyStar()->GetId() == $post->GetOwner()->GetId()) {
                        echo " | <a class='link-form' href='editpost.php?post=$postid'>Editar Post</a>";
                    }
                    ?>
                </small></span>
        </div>
    </section>
    <!-- Post Header -->

    <!-- Post -->
    <nain>
        <?php
        $commentaries_count = 0;
        $comments_range = 5; //The number of commentaries to present

        if ($post->HasError()) {
        ?>
            <h4 class="centered">Post não identificado!</h4>
        <?php
        } else {
            $commentaries_count = $post->CommentariesCount();
            include("lib/embeds/post_div.php");
        }
        ?>
        </main>
        <!-- Post -->

        <!-- Commentaries -->
        <section>
            <?php
            $default_display = "block";
            $present_all = true;
            include("lib/embeds/post_comments.php");
            ?>
        </section>
        <!-- Commentaries -->

        <!-- Commentary Form -->
        <?php if (!$post->HasError()) include("lib/embeds/comment_form_div.php"); ?>
        <!-- Commentary Form -->

        
        <section class="section-see-more">
            <?php
            if ($commentaries_count > $comments_range) {
                if ($comments_start_index > 0) {
                    $previous = $comments_start_index - $comments_range;
                    if ($previous < 0)
                        $previous = 0;
                    echo "<a  class='link-simple'  href=post.php?post=$postid&comments_start_index=$previous>+ Antigo</a>";
                }
                if ($comments_start_index < $default_comments_start_index) {
                    $next = $comments_start_index + $comments_range;
                    if ($next > $default_comments_start_index)
                        $next = $default_comments_start_index;
                    echo "<a  class='link-simple'  href=post.php?post=$postid&comments_start_index=$next>+ Recente</a>";
                }
            }
            ?>
        </section>
     
        <footer>
            <?php include("lib/embeds/copyright.php"); ?>
        </footer>
</body>

</html>