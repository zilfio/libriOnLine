<br />
<div class="alert alert-info alert-dismissable">
  <strong>Info!</strong>
  <p>{$message}</p>
  {if $errori}
  <ul>
  {foreach from=$errori item=errore}
      <li>{$errore}</li>
  {/foreach}
  </ul>
  {/if}
</div>