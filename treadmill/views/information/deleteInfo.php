<?php echo form_open('GetInformation/deleteInfo/'.$title)?>

<select name='column' id='column'>
<?php foreach($columns as $column):?>
<option value=<?php echo $column['Field']?>><?php echo $column['Field']?></option>
<?php endforeach;?>
</select>

<input type='input' name='text'/>
<input type='submit' name='btnModify' value='刪除'/>

</form>