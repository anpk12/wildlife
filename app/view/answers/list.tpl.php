<h1><?=$title?></h1>

<table class="answers_view">
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
<tr>
<td>
<p><a href='<?=$this->url->create('comment2/comment-answer/'
    . $question->id . '/' .$a->id)?>'>Comment
</a></p>
</td>
</tr>

<?php endforeach; ?>
</table>

<p>
    <a href='<?=$this->url->create('questions/answer/' . $question->id)?>'>
        Answer this question
    </a>
</p>

<p><a href='<?=$this->url->create('questions/list')?>'>All questions</a></p>

