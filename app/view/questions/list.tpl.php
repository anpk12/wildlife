<h1><?=$title?></h1>

<table class="questions_overview">
<?php foreach ($questions as $q) : ?>

<tr>
<td>n answers</td>
<td><?=$q->topic?></td>
<td><?=$q->userAcronym?></td>
<td><?=$q->created?></td>
</tr>

<?php endforeach; ?>
</table>

<p><a href='<?=$this->url->create('')?>'>Home</a></p>

