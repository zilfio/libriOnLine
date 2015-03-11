<br />
<div class="alert alert-danger alert-dismissable">
	<button type="button" class="close" data-dismiss="alert"
		aria-hidden="true">&times;</button>
	<strong>Error!</strong>
	<p>{$message}</p>
	{if $errori}
	<ul>
		{foreach from=$errori item=errore}
		<li>{$errore}</li> 
		{/foreach}
	</ul>
	{/if}
</div>
