<div class='comment-form'>
    <form method=post>
        <input type=hidden name="flow" value="<?=$flow?>">
        <fieldset>
        <legend>Lämna en kommentar</legend>
        <p><label>Kommentar:<br/><textarea name='content'><?=$content?></textarea></label></p>
        <p><label>Namn:<br/><input type='text' name='name' value='<?=$name?>'/></label></p>
        <p><label>Webbsida:<br/><input type='text' name='web' value='<?=$web?>'/></label></p>
        <p><label>Epost:<br/><input type='text' name='mail' value='<?=$mail?>'/></label></p>
        <p class=buttons>
            <input type='submit' name='doCreate' value='Skicka kommentar' onClick="this.form.action = '<?=$this->url->create('comment/add')?>'"/>
            <input type='reset' value='Återställ formuläret'/>
            <input type='submit' name='doRemoveAll' value='Radera alla kommentarer' onClick="this.form.action = '<?=$this->url->create('comment/remove-all')?>'"/>
        </p>
        <output><?=$output?></output>
        </fieldset>
    </form>
</div>
