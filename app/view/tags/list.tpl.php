<h1><?=$title?></h1>

<ul>
<?php foreach ($tags as $tag) : ?>

<li><?=$tag->name?></li>
<ul>
<li><?=$tag->description?></li>
</ul>

<?php endforeach; ?>
</ul>

<p><a href='<?=$this->url->create('')?>'>Home</a></p>

