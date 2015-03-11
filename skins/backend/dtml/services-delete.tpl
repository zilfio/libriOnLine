<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Eliminazione servizio</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <fieldset disabled="disabled">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" name="nome" value="{$service->getNome()}"/>
        </div>
        <div class="form-group">
            <label for="descrizione">Descrizione</label>
            <textarea class="form-control" name="descrizione">{$service->getDescrizione()}</textarea>
        </div>
        <div class="form-group">
            <label for="script">Script</label>
            <input type="text" class="form-control" name="script" value="{$service->getScript()}" />
        </div>
    </fieldset>
    <button type="submit" class="btn btn-danger">Elimina Servizio</button>
</form>