<form method="POST" action="<?php echo url_for('/')?>">
	<table>
		<tr>
			<td>Name</td>
			<td><input type="text" name="name" value="<?php echo h($post['name']);?>" class="<?php echo in_array('name', $errors) ? 'error' : ''; ?>" maxlength="50"></td>
		</tr>
			<td>Birth-date</td>
			<td><input type="date" name="date" value="<?php echo h($post['date']);?>" class="<?php echo in_array('date', $errors) ? 'error' : ''; ?>"></td>
		</tr>
		<tr>
			<td colspan="2"><input type="checkbox" name="newsletter" value="1"  
			<?php echo $post['newsletter'] == 1 
				? ' checked="checked"' 
				: '';?>> I want to receive your newsletter</td>
		</tr>
		<tr>
			<td colspan="2">
				<input type="submit">
			</td>
		</tr>
	</table>
</form>