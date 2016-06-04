<h1><?=$title?></h1>

<ul>
<?php foreach ($tags as $tag) : ?>

<li><a href='<?=$this->url->create("questions/tagged/$tag->name")?>'><?=$tag->name?></a>
<?php if ( isset($tag->popularity) ) : ?>
 (<?=$tag->popularity?>)
<?php endif; ?>
</li>
<ul>
<li><?=$tag->description?>
</li>
</ul>

<?php endforeach; ?>
</ul>

