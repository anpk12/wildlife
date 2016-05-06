<h1><?=$title?></h1>

<table class="question_view">
<tr>
<td><?=$question->topic?></td>
<td><?=$question->userAcronym?></td>
<td><?=$question->created?></td>
</tr>
<tr>
<td><?=$question->text?></td>
</tr>
<tr>
<td>
<?php foreach ($question->tags as $tag) : ?>
<?=$tag->name?>, 
<?php endforeach; ?>
</td>
</tr>
<?php foreach ($question->comments as $qc) : ?>
<tr>
<td>
    <p><?=$qc->content?> by <?=$qc->user->acronym?></p>
</td>
</tr>
<?php endforeach; ?>

<?php foreach ($answers as $a) : ?>

<tr>
<td><?=$a->votes?> votes</td>
<td><?=$a->text?></td>
<td><?=$a->userAcronym?></td>
<td><?=$a->created?></td>
</tr>
<?php foreach ($a->comments as $ac) : ?>
<tr>
<td>
    <p><?=$ac->content?> by <?=$ac->user->acronym?></p>
</td>
</tr>
<?php endforeach; ?>

<?php endforeach; ?>
</table>

<p>
    <a href='<?=$this->url->create('questions/answer/' . $question->id)?>'>
        Answer this question
    </a>
</p>

<p><a href='<?=$this->url->create('questions/list')?>'>All questions</a></p>

