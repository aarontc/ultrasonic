<h1>Library Management</h1>
<div class="divider2"></div>
<div class="post">
	<h4>Collections</h4>
	<div class="contentarea">
		<table border=1>
			<tr>
				<th>Path</th>
			</tr>
			{foreach from=$Collections item=c}
			<tr>
				<td>{$c->path}</td>
			</tr>
			{/foreach}
		</table>
	</div>
</div>
