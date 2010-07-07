<h1>Library Management</h1>
<div class="divider2"></div>
<div class="post">
	<h4>Collections</h4>
	<div class="contentarea">
		<table border=1>
			<tr>
				<th>Path</th>
				<th>Actions</th>
			</tr>
			{foreach from=$Collections item=c}
			<tr>
				<td>{$c->path}</td>
				<td><a href="/index.php/admin/collections/{$c->id}/scan">[scan]</a> <a href="/index.php/admin/collections/{$c->id}/delete">[delete]</a></td>
			</tr>
			{/foreach}
		</table>
	</div>
</div>
