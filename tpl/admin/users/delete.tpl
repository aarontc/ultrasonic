<form method='post'>
<fieldset>
	<legend>Delete User</legend>
	<p style="color: red;">Are you sure you wish to delete {$User->login} ({$User->first_name} {$User->last_name})? This cannot be undone.</p>
	<input type='submit' name='confirm' value='Cancel'/> <input type='submit' name='confirm' value='Delete User'/>
</fieldset>
</form>