<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Inserimento gruppo</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
{if $warning}
    {include file="alert-warning.tpl"}
{/if}
{if $error}
    {include file="alert-error.tpl"}
{/if}
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <div class="form-group">
        <label for="username">Nome</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="nome" placeholder="Inserisci nome" value="{$nome}" />
    </div>
    <div class="form-group">
        <label for="email">Descrizione</label>
        <textarea class="form-control" name="descrizione" placeholder="Inserisci descrizione">{$descrizione}</textarea>
    </div>
    <div class="form-group">
        <label for="servizi">Servizi</label>
        <select multiple class="form-control select2" name="servizi[]" placeholder="Inserisci servizi">
            {foreach from=$servicesSel item=servizioSel}
                <option selected="selected" value="{$servizioSel->getId()}">{$servizioSel->getNome()}</option>
            {/foreach}
            {foreach from=$servicesNotSel item=serviceNotSel}
                <option value="{$serviceNotSel->getId()}">{$serviceNotSel->getNome()}</option>
            {/foreach}
        </select>
    </div>
    <button type="submit" class="btn btn-success">Inserisci Gruppo</button>
    <button type="reset" class="btn btn-default">Reset</button>
</form>