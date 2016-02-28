<hr>

<h2>Kommentarer</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $id => $comment) : ?>
<h4><a href="<?=$this->url->create("$flow?edit=$id")?>">#<?=$id?></a> (<a href="<?=$this->url->create("comment/delete?commentId=$id&redirect=$flow")?>">delete</a>) <?=$comment['name']?> <?=date('Y-m-d H:i T', $comment['timestamp'])?></h4>
<div class="comment">
<img class="avatar" src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($comment['mail'])))?>" />
<?=$comment['content']?>
</div>
<?php endforeach; ?>
</div>
<div style="clear: both"></div>
<?php if ( !$showform ) : ?>
<a class="postcomment" href="<?=$this->url->create("$flow?showform=1")?>">Lägg till en kommentar</a>
<?php endif; endif; ?>
