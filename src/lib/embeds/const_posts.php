<?php
namespace Space;

 $constellation = new Constellation($const);
 $posts_count = $constellation->PostsCount();

if (is_bool($posts_count)) $posts_count = 0;

$posts_range = 5; //How many posts for each page
$default_posts_start_index = ($posts_count) - $posts_range;
$posts_start_index = (isset($_GET["posts_start_index"])) ? $_GET["posts_start_index"] : $default_posts_start_index;

if ($posts_count < 1) {
    echo "<h3 class='centered'>Sem Posts</h3>";
} else {

    if (!is_numeric($posts_start_index))
        $posts_start_index = $default_posts_start_index;
    if ($posts_start_index > $default_posts_start_index)
        $posts_start_index = $default_posts_start_index;
    if ($posts_start_index < 0)
        $posts_start_index = 0;

    $posts = $constellation->GetPosts($posts_start_index, $posts_range);

    for ($posts_row = 0; $posts_row < count($posts); $posts_row++) {
        $post = new Post($posts[$posts_row]["id"]);
        $commentaries_count = $post->CommentariesCount();
        if (is_bool($commentaries_count))
            $commentaries_count = 0;
        ?>

        <!-- Post -->
        <div style="margin-top: 10px;" id="<?= 'post_' . $post->GetId(); ?>">

            <!-- Post Table -->
            <?php include("post_div.php"); ?>
            <!-- Post Table -->

            <!-- Commentaries -->
        <?php
        $default_display = "none";
        $comments_range = 3;
        include("post_comments.php");
        ?>
            <!-- Commentaries -->

            <!-- Commentary Form -->
        <?php include("comment_form_div.php"); ?>
            <!-- Commentary Form -->

        </div>
        <!-- Post -->
    <?php }
} ?>             