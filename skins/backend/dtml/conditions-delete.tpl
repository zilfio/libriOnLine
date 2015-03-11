<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Eliminazione condizione</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <fieldset disabled="disabled">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" name="nome" value="{$condition->getNome()}"/>
        </div>
        <div class="form-group">
            <label for="descrizione">Descrizione</label>
            <textarea class="form-control" name="descrizione">{$condition->getDescrizione()}</textarea>
        </div>
    </fieldset>
    <button type="submit" class="btn btn-danger">Elimina Condizione</button>
</form>