<h1>User Management</h1>
<div class="divider2"></div>
<div class="post">
	<h4>Users</h4>
	<div class="contentarea">
		<table border=1>
			<tr>
				<th>Login</th>
				<th>First Name</th>
				<th>Last Name</th>
				<th>Roles</th>
				<th>Actions</th>
			</tr>
			{foreach from=$Users item=u}
			<tr>
				<td>{$u->login|escape}</td>
				<td>{$u->first_name|escape}</td>
				<td>{$u->last_name|escape}</td>
				<td>{$u->roles}</td>
				<td>
					<a href="/index.php/admin/users/{$u->login|escape:urlencode}/set_password">[Set Password]</a> |
					<a href="/index.php/admin/users/{$u->login|escape:urlencode}/edit">[Edit]</a> |
					<a href="/index.php/admin/users/{$u->login|escape:urlencode}/delete">[Delete]
				</td>
			</tr>
			{/foreach}
		</table>
	</div>
</div>
