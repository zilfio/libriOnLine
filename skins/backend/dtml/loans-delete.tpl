<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Eliminazione prestito</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <fieldset disabled="disabled">
        <div class="form-group">
            <label for="volume">Volume</label>
            <select class="form-control" name="volume" disabled="disabled">
                <option value="{$loan->getVolume()->getId()}">{$loan->getVolume()->getLibro()->getTitolo()} - Numero copia: {$loan->getVolume()->getId()} - {$loan->getVolume()->getCondizione()->getNome()} </option>
            </select>
        </div>
        <div class="form-group">
            <label for="duratamax">Durata Max Prestito</label>
            <input type="text" class="form-control" name="duratamax" value="{$loan->getDurataMax()}"/>
        </div>
        <div class="form-group">
            <label for="utente">Utente</label>
            <select class="form-control" name="utente" disabled="disabled">
                <option value="{$loan->getUtente()->getId()}">{$loan->getUtente()->getUsername()}</option>
            </select>
        </div>
    </fieldset>
    <button type="submit" class="btn btn-danger">Elimina Prestito</button>
</form>