<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Eliminazione utente</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <fieldset disabled="disabled">
        <div class="form-group">
            <label for="username">Username</label>
            <input type="text" class="form-control" name="username" value="{$user->getUsername()}"/>
        </div>
        <div class="form-group">
            <label for="email">Email</label>
            <textarea class="form-control" name="email">{$user->getEmail()}</textarea>
        </div>
        <div class="form-group">
            <label for="gruppi">Gruppi</label>
            <select multiple class="form-control select2" name="gruppi[]" disabled="disabled">
                {foreach from=$user->getGruppi() item=gruppo}
                    <option selected="selected" value="{$gruppo->getId()}">{$gruppo->getNome()}</option>
                {/foreach}
            </select>
        </div>
    </fieldset>
    <button type="submit" class="btn btn-danger">Elimina Utente</button>
</form>