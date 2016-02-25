<hr>

<h2>Comments</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $id => $comment) : ?>
<h4>Comment <a href="<?=$this->url->create("$flow?edit=$id")?>">#<?=$id?></a> <a href="<?=$this->url->create("comment/delete?commentId=$id&redirect=$flow")?>">delete</a></h4>
<img src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($comment['mail'])))?>" />
<p><?=dump($comment)?></p>
<?php endforeach; ?>
</div>
<?php if ( !$showform ) : ?>
<a href="<?=$this->url->create("$flow?showform=1")?>">Post a comment</a>
<?php endif; endif; ?>
