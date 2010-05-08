{if $ProfileMode == "Updated"}
	Profile Updated!
{elseif $ProfileMode == "DisplayFields"}
	<form method="post">
		First Name: 
		<input type="text" name="firstname" value={$UserInfo.firstname} />
		<br />
		Last Name: 
		<input type="text" name="lastname" value={$UserInfo.lastname} />
		<br />
		E-Mail Address: 
		<input type="text" name="email" value={$UserInfo.email} />
		<br />
		<input type="submit" value="Submit Changes" />
	</form>
{/if}