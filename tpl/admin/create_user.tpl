<form method='post'>
<fieldset>
	<legend>New User</legend>
	<label for='login'>Login:</label>
	<input type='text' value='{$login|escape:htmlall}' name='login'/><br/>

	<label for='first_name'>First name:</label>
	<input type='text' value='{$first_name|escape:htmlall}' name='first_name'/><br/>

	<label for='last_name'>Last name:</label>
	<input type='text' value='{$last_name|escape:htmlall}' name='last_name'/><br/>

	<fieldset>
		<legend>Password</legend>
		<label for='password'>Password:</label>
		<input type='password' value='{$password|escape:htmlall}' name='password'/><br/>

		<label for='password_verify'>Verify:</label>
		<input type='password' value='{$password_verify|escape:htmlall}' name='password_verify' id='password_verify'/><br/>
	</fieldset>
	<fieldset>
		<legend>Permissions</legend>
		Administrator: <input type='checkbox' name='roles[]' value='admin' {$admin_checked} {$admin_disabled}/><br/>
		Edit metadata: <input type='checkbox' name='roles[]' value='editor' {$editor_checked}/><br/>
	</fieldset>
	<input type='submit' value='Create User'/>
</fieldset>
</form>