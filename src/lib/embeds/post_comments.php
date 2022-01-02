<?php

namespace Space;

$default_comments_start_index = ($commentaries_count) - $comments_range;
$comments_start_index = (isset($_GET["comments_start_index"])) ? $_GET["comments_start_index"] : $default_comments_start_index;
?>

<div id="<?= 'post_' . $post->GetId() . "_commentaries_div"; ?>" style="display: <?= $default_display; ?>;">
    <?php if ($commentaries_count < 1) { ?>
        <table class="table-commentary" cellpadding="4">
            <thead>
                <tr>
                    <td>
                        <small style="color:gray;"> Ainda ninguém comentou...</small>
                        <hr size='1px' color='black' />
                    </td>
                </tr>
            </thead>
        </table>
    <?php
    } else {

        if (!is_numeric($comments_start_index))
            $comments_start_index = $default_comments_start_index;
        if ($comments_start_index > $default_comments_start_index)
            $comments_start_index = $default_comments_start_index;
        if ($comments_start_index < 0)
            $comments_start_index = 0;

        $commentaries = $post->GetCommentaries($comments_start_index, $comments_range);

        for ($comment_row = 0; $comment_row < count($commentaries); $comment_row++) {
            $commentary = new Commentary($commentaries[$comment_row]["id"]);

            include("commentary_div.php");
        }
    } ?>
</div>