<?php namespace Space; ?>

<div class="post">
    <table class="width-all" cellpadding="4" >
        <thead>
            <tr>
                <th>
                <img alt="Space" style="border-radius: 100%;float:left" src="<?= "images/stars/star" . $post->GetOwner()->GetId(). "/" . $post->GetOwner()->GetImageName(); ?>" width="30px" height="30px"/>
                </th>
                <th colspan="4" align="right">
                    <a style="font-size: 10px;" class="link-star" href="profile.php?star=<?= $post->GetOwner()->GetId(); ?>" >@<?= $post->GetOwner()->GetName(); ?></a>
                </th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td colspan="4" >
                    <div class="content-post break-words"> 
                    <?= str_replace("\n", "<br/>", $post->GetContent()); ?>
                    </div>
                </td>
            </tr>
        </tbody>
        <tfoot>
            <tr>
                <td align="left" style="font-size: 12px;">
                    <span  class="link-simple" onclick="View_Post_Commentaries('<?= 'post_' . $post->GetId(); ?>')">Comentários <?php if ($post->CommentariesCount() > 0) echo "(" . $post->CommentariesCount() . ")"; ?></span>
                </td>
                <td align="center" style="font-size: 12px;">
                    <small>
                        <a class="link-simple" href="post.php?post=<?= $post->GetId(); ?>">Post</a>
                    </small>
                </td>
                <td align="center" style="font-size: 12px;">
                    <small>
                        <?php
                        if ($post->GetOwner()->GetId() == Star::MyStar()->GetId()) {
                            $postid = $post->GetId();
                            echo "<a class='link-simple' href='lib/intermediates/get_intermediate.php?command=delete_post&id=$postid'>Eliminar</a>";
                        }
                        ?>
                    </small>
                </td>
                <td align="right" style="font-size: 10px; color: gray;">
                    <small>
                        <?php
                        echo $post->GetDate() . " | " . $post->GetTime();
                        ?>
                    </small>
                </td>
            </tr>
        </tfoot>
    </table>
</div>