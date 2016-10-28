<?php echo form_open('GetInformation/clickSearch/'.$title)?>

<select name='column' id='column'>
<?php foreach($columns as $column):?>
<option value=<?php echo $column['Field']?>><?php echo $column['Field']?></option>
<?php endforeach;?>
</select>

<input type='input' name='text'/>
<input type='submit' name='btnSearch' value='查詢'/>

</form>
