<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Inserimento servizio</h1>
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
        <label for="nome">Nome</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="nome" placeholder="Inserisci nome" value="{$nome}" />
    </div>
    <div class="form-group">
        <label for="descrizione">Descrizione</label>
        <textarea class="form-control" name="descrizione" placeholder="Inserisci descrizione">{$descrizione}</textarea>
    </div>
    <div class="form-group">
        <label for="script">Script</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="script" placeholder="Inserisci script" value="{$script}" />
    </div>
    <button type="submit" class="btn btn-success">Inserisci Servizio</button>
    <button type="reset" class="btn btn-default">Reset</button>
</form>