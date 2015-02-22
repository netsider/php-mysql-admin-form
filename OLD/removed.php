	<tr>
		<td><?php echo $results[1] ?></td>
		<td><input type="text" name="title" value="<?php echo $row[$results[1]] ?>"/></td>
	</tr>
	<tr>
		<td><?php echo $results[2] ?></td>
		<td><input type="text" name="author" value="<?php echo $row[$results[2]] ?>"/></td>
	</tr>
	<tr>
		<td><?php echo $results[3] ?></td>
		<td><input type="text" name="name" value="<?php echo $row[$results[3]] ?>"/></td>
	</tr>
	<tr>
		<td><?php echo $results[4] ?></td>
		<td><input type="text" size="50" name="copy" value="<?php echo $row[$results[4]] ?>"/></td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><input type="submit" name="save" value="save" /></td>
	</tr> 