<form method="post">
<fieldset>
	<legend>Login</legend>
	Login: <input type="text" name="login" value="{$login|escape:htmlall}" />
	<br />
	Password: <input type="password" name="password" />
	<input type="submit" value="Login" />
</fieldset>
</form>