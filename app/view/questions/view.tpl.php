<h1><?=$title?></h1>

<table class="question_view">
<tr>
<td><?=$question->topic?></td>
<td><?=$question->userAcronym?></td>
<td><?=$question->created?></td>
</tr>
<tr>
<td><?=$this->textFilter->doFilter($question->text, 'shortcode, markdown')?></td>
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
    <p><?=$this->textFilter->doFilter($qc->content, 'shotcode, markdown')?> by <?=$qc->user->acronym?></p>
</td>
</tr>
<?php endforeach; ?>
<tr>
<td>
    <p><a href='<?=$this->url->create('comment2/comment-question/' . $question->id)?>'>Comment</a></p>
</td>
</tr>

<?php foreach ($answers as $a) : ?>

<tr>
<td><?=$a->votes?> votes</td>
<td><?=$this->textFilter->doFilter($a->text, 'shortcode, markdown')?></td>
<td><?=$a->userAcronym?></td>
<td><?=$a->created?></td>
</tr>
<?php foreach ($a->comments as $ac) : ?>
<tr>
<td>
    <p><?=$this->textFilter->doFilter($ac->content, 'shortcode, markdown')?> by <?=$ac->user->acronym?></p>
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

