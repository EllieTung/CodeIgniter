<table style="border:3px #cccccc solid;" border='1'>
<tr>
<?php foreach ($columns as $column):?>
<?php echo '<th>'.$column['Field'].'</th>'?>
<?php endforeach;?></tr>

<?php foreach($infos as $info):?>
<tr>
<?php foreach ($columns as $column):?>
<?php echo '<td>'.$info[$column['Field']].'</td>'?>
<?php endforeach;?>
</tr>
<?php endforeach;?>
</table>





