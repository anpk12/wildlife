<hr>

<h2>Comments</h2>

<?php if (is_array($comments)) : ?>
<div class='comments'>
<?php foreach ($comments as $id => $comment) : ?>
<h4>Comment <a href="<?=$this->url->create("$flow?edit=$id")?>">#<?=$id?></a> <a href="<?=$this->url->create("comment/delete?commentId=$id&redirect=$flow")?>">delete</a></h4>
<p><?=dump($comment)?></p>
<?php endforeach; ?>
</div>
<?php endif; ?>
