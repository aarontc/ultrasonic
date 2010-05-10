<form method='post'>
<fieldset>
	<legend>Edit User</legend>
	<label for='login'>Login:</label>
	<input type='text' value='{$User->login|escape:htmlall}' name='login'/><br/>

	<label for='first_name'>First name:</label>
	<input type='text' value='{$User->first_name|escape:htmlall}' name='first_name'/><br/>

	<label for='last_name'>Last name:</label>
	<input type='text' value='{$User->last_name|escape:htmlall}' name='last_name'/><br/>

	<fieldset>
		<legend>Permissions</legend>
		Administrator: <input type='checkbox' name='roles[]' value='admin' {if in_array('admin', $User->roles)}checked{/if}/><br/>
		Edit metadata: <input type='checkbox' name='roles[]' value='editor' {if in_array('editor', $User->roles)}checked{/if}/><br/>
	</fieldset>
	<input type='submit' value='Save Changes'/>
</fieldset>
</form>