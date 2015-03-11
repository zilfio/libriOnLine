<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Eliminazione gruppo</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <fieldset disabled="disabled">
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" name="nome" value="{$group->getNome()}"/>
        </div>
        <div class="form-group">
            <label for="descrizione">Descrizione</label>
            <textarea class="form-control" name="descrizione">{$group->getDescrizione()}</textarea>
        </div>
        <div class="form-group">
            <label for="servizi">Servizi</label>
            <select multiple class="form-control select2" name="servizi[]" disabled="disabled">
                {foreach from=$group->getServizi() item=servizio}
                    <option selected="selected" value="{$servizio->getId()}">{$servizio->getNome()}</option>
                {/foreach}
            </select>
        </div>
    </fieldset>
    <button type="submit" class="btn btn-danger">Elimina Gruppo</button>
</form>