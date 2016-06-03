<h1><?=$title?></h1>

<ul>
<?php foreach ($users as $user) : ?>

<li><a href='<?=$this->url->create("users/id/$user->id")?>'/><?=$user->acronym?></a></li>


<?php endforeach; ?>
</ul>

<p><a href='<?=$this->url->create('')?>'>Home</a></p>

