<?php namespace Space; ?>

<div class="blacker" id="<?= 'post_' . $post->GetId() . "_commentary_form"; ?>" style="display: <?= $default_display; ?>">
    <form class="form-commentary" action="lib/intermediates/post_intermediate.php" method="post">
        <div style="margin-left: 6px;">   
            <input type="hidden" name="postid" value="<?= $post->GetId(); ?>" />
            <input type="hidden" name="command" value="send_commentary" />
            <textarea placeholder="Escreva um comentário..."required class="textarea-comment" name="content"></textarea><br/>
            <input type="submit" Value="Comentar" class="button-comment" />
        </div>
    </form>
</div>
