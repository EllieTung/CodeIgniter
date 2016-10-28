<?php echo form_open('GetInformation/modifyInfo/'.$title)?>
<select name='mName' id='mName'>
<?php foreach($infos as $info):?>
<option value=<?php echo $info['mName']?>><?php echo $info['mName']?></option>
<?php endforeach;?>
</select>

<select name='column' id='column'>
<?php foreach($columns as $column):?>
<option value=<?php echo $column['Field']?>><?php echo $column['Field']?></option>
<?php endforeach;?>
</select>

<input type='input' name='text'/>
<input type='submit' name='btnModify' value='修改'/>

</form>

