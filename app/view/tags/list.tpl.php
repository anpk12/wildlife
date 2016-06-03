<h1><?=$title?></h1>

<ul>
<?php foreach ($tags as $tag) : ?>

<li><a href='<?=$this->url->create("questions/tagged/$tag->name")?>'><?=$tag->name?></a></li>
<ul>
<li><?=$tag->description?></li>
</ul>

<?php endforeach; ?>
</ul>

