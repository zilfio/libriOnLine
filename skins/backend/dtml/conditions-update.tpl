{if $warning}
    {include file="alert-warning.tpl"}
{/if}

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Modifica condizione</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <div class="form-group">
        <label for="nome">Nome</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="nome" value="{$nome}"/>
    </div>
    <div class="form-group">
        <label for="descrizione">Descrizione</label>
        <textarea class="form-control" name="descrizione">{$descrizione}</textarea>
    </div>
    <button type="submit" class="btn btn-warning">Modifica Condizione</button>
    <button type="reset" class="btn btn-default">Reset</button>
</form>