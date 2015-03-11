<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Modifica servizio</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
{include file="alert.tpl"}
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
    <div class="form-group">
        <label for="script">Script</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="script" value="{$script}" />
    </div>
    <button type="submit" class="btn btn-warning">Modifica Servizio</button>
    <button type="reset" class="btn btn-default">Reset</button>
</form>