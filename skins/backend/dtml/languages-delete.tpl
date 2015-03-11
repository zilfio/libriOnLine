<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Eliminazione lingua</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <fieldset disabled="disabled">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" name="nome" value="{$language->getNome()}"/>
        </div>
    </fieldset>
    <button type="submit" class="btn btn-danger">Elimina Lingua</button>
</form>