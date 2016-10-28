<?php echo validation_errors(); ?>
<?php echo form_open('GetInformation/addInfo/'.$title)?>
<?php foreach ($columns as $column):?>
<label for='<?php echo $column['Field'] ?>'><?php echo $column['Field'] ?></label>
<input type='input' name='<?php echo $column['Field']?>' /><br>
<?php endforeach;?>
<input type='submit' name='btnAdd' value='新增'/>
</form>

