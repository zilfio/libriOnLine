<br />
<div class="alert alert-warning alert-dismissable">
  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
  <strong>Warning!</strong> {$message}
  {if $errori}
  <ul>
  {foreach from=$errori item=errore}
      <li>{$errore}</li>
  {/foreach}
  </ul>
  {/if}
</div>