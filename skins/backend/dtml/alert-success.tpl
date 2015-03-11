<br />
<div class="alert alert-success alert-dismissable">
  <strong>Well done!!</strong>
  <p>{$message}</p>
  {if $errori}
  <ul>
  {foreach from=$errori item=errore}
      <li>{$errore}</li>
  {/foreach}
  </ul>
  {/if}
</div>