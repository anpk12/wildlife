<div class='comment-form'>
    <form method=post>
        <input type=hidden name="redirect" value="<?=$this->url->create('guestbook')?>">
        <input type=hidden name="commentId" value="<?=$commentId?>">
        <fieldset>
        <legend>Edit comment</legend>
        <p><label>Comment:<br/><textarea name='content'><?=$content?></textarea></label></p>
        <p><label>Name: <?=$name?></label></p>
        <p><label>Homepage: <?=$web?></label></p>
        <p><label>Email: <?=$mail?></label></p>
        <p class=buttons>
            <input type='submit' name='doCreate' value='Update' onClick="this.form.action = '<?=$this->url->create("comment/update")?>'"/>
            <input type='reset' value='Reset'/>
        </p>
        <output><?=$output?></output>
        </fieldset>
    </form>
</div>
