<hr>

<h2>Kommentarer</h2>

<?php if (is_array($comments)) : ?>

<div class='comments'>
<?php foreach ($comments as $comment) : ?>
<h4><a href="<?=$this->url->create("comment/update/$flow/$comment->id") ?>" title="Edit">#<?=$comment->id?></a>
(<a href="<?=$this->url->create("comment/delete/$flow/$comment->id")?>">delete</a>)
<?=$comment->name?> <?=$comment->timestamp?></h4>

<div class="comment">
<img class="avatar" src="http://www.gravatar.com/avatar/<?=md5(strtolower(trim($comment->email)))?>" />
<?=$comment->content?>
</div>

<?php endforeach; ?>
</div>
<div style="clear: both"></div>
<?php if ( !$showform ) : ?>
<a class="postcomment" href="<?=$this->url->create("comment/add/$flow")?>">Lägg till en kommentar</a>
<?php endif; endif; ?>
