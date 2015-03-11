<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Eliminazione volume</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <fieldset disabled="disabled">
        <div class="form-group">
            <label for="libro">Libro</label>
            <select class="form-control" name="libro" disabled="disabled">
                <option value="{$volume->getLibro()->getIsbn()}">{$volume->getLibro()->getTitolo()}</option>
            </select>
        </div>
        <div class="form-group">
            <label for="condizione">Condizione</label>
            <select class="form-control select2" name="condizione" disabled="disabled">
                <option value="{$volume->getCondizione()->getId()}">{$volume->getCondizione()->getNome()}</option>
            </select>
        </div>
    </fieldset>
    <button type="submit" class="btn btn-danger">Elimina Volume</button>
</form>