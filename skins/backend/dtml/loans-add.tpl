<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Prestito libro</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
{if $warning}
    {include file="alert-warning.tpl"}
{/if}
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <div class="form-group">
        <label for="volume">Volume</label>
        <select class="form-control select2" name="volume">
            {if $selectedVolume}
            <option selected="selected" value="{$selectedVolume->getId()}">{$selectedVolume->getLibro()->getTitolo()} - Numero copia: {$selectedVolume->getId()} - {$selectedVolume->getCondizione()->getNome()}</option>
            {/if}
            {foreach from=$volumes item=volume}
                <option value="{$volume->getId()}">{$volume->getLibro()->getTitolo()} - Numero copia: {$volume->getId()} - {$volume->getCondizione()->getNome()}</option>
            {/foreach}
        </select>
    </div>
    <div class="form-group">
        <label for="duratamax">Durata Max</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="duratamax" placeholder="Inserisci durata massima" value="{$duratamax}" />
    </div>
    <div class="form-group">
        <label for="utente">Utente</label>
        <select class="form-control select2" name="utente">
            {if $selectedUser}
            <option selected="selected" value="{$selectedUser->getId()}">{$selectedUser->getUsername()}</option>
            {/if}
            {foreach from=$users item=user}
                <option value="{$user->getId()}">{$user->getUsername()} - {$user->getNome()} {$user->getCognome()}</option>
            {/foreach}
        </select>
    </div>
    <button type="submit" class="btn btn-success">Presta Volume</button>
    <button type="reset" class="btn btn-default">Reset</button>
</form>