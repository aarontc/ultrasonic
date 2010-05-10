{if count($FlashError) > 0}
<div class="flasherror">
	{foreach from=$FlashError item=msg}
	<p>{$msg}</p>
	{/foreach}
</div>
{/if}
{if count($FlashWarning) > 0}
<div class="flashwarning">
	{foreach from=$FlashWarning item=msg}
	<p>{$msg}</p>
	{/foreach}
</div>
{/if}
{if count($FlashInfo) > 0}
<div class="flashinfo">
	{foreach from=$FlashInfo item=msg}
	<p>{$msg}</p>
	{/foreach}
</div>
{/if}
{if count($FlashSuccess) > 0}
<div class="flashsuccess">
	{foreach from=$FlashSuccess item=msg}
	<p>{$msg}</p>
	{/foreach}
</div>
{/if}