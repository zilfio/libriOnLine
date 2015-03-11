<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Inserimento tag</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
{if $warning}
    {include file="alert-warning.tpl"}
{/if}
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <div class="form-group">
        <label for="nome">Nome</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="nome" placeholder="Inserisci nome" value="{$nome}" autofocus />
    </div>
    <button type="submit" class="btn btn-success">Inserisci Tag</button>
    <button type="reset" class="btn btn-default">Reset</button>
</form>