<h1><?=$title?></h1>

<table class="question_view">
<tr>
<th colspan="2"><?=$question->topic?></td>
</tr>
<tr>
<td>0 votes</td>
<td><?=$this->textFilter->doFilter($question->text, 'shortcode, markdown')?></td>
</tr>
<tr>
<td colspan="2">
<?php foreach ($question->tags as $tag) : ?>
<a href="<?=$this->url->create("questions/tagged/$tag->name")?>"><?=$tag->name?></a> 
<?php endforeach; ?>
</td>
</tr>
<tr>
<td>by <a href="<?=$this->url->create('users/id/'.$question->userid)?>"><?=$question->userAcronym?></a></td>
<td><?=$question->created?></td>
</tr>
<tr>
<td colspan="2">
<ul>
<?php foreach ($question->comments as $qc) : ?>
<li>
    <p><?=$this->textFilter->doFilter($qc->content, 'shortcode, markdown')?> by <a href="<?=$this->url->create('users/id/'.$qc->user->id)?>"><?=$qc->user->acronym?></a></p>
</li>
<?php endforeach; ?>
</ul>
</td>
</tr>
<tr>
<td colspan="2">
    <p><a href='<?=$this->url->create('comment2/comment-question/' . $question->id)?>'>Comment</a></p>
</td>
</tr>
</table>
<table class="answers_view">
<tr>
<th colspan="2">Answers</th>
</tr>
<?php foreach ($answers as $a) : ?>
<tr>
<td><?=$a->votes?> votes</td>
<td><?=$this->textFilter->doFilter($a->text, 'shortcode, markdown')?></td>
</tr>
<tr>
<td><a href="<?=$this->url->create('users/id/'.$a->userid)?>"><?=$a->userAcronym?></a></td>
<td><?=$a->created?></td>
</tr>
<tr>
<td colspan="2">
<ul>
<?php foreach ($a->comments as $ac) : ?>

<li>
    <p><?=$this->textFilter->doFilter($qc->content, 'shortcode, markdown')?> by <a href="<?=$this->url->create('users/id/'.$qc->user->id)?>"><?=$qc->user->acronym?></a></p>
</li>

<?php endforeach; ?>
</ul>
</td>
</tr>
<tr>
<td colspan="2">
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

