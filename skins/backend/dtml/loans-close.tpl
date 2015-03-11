<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Chiusura prestito</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <fieldset disabled>
        <div class="form-group">
            <label for="id">Codice Prestito</label>
            <input type="text" class="form-control" name="id" value="{$loan->getId()}"/>
        </div>
        <div class="form-group">
            <label for="duratamax">Durata Max Prestito</label>
            <input type="text" class="form-control" name="duratamax" value="{$loan->getDurataMax()}"/>
        </div>
        <div class="form-group">
            <label for="dataprestito">Data Prestito</label>
            <input type="text" class="form-control" name="dataprestito" value="{$loan->getDataPrestito()|date_format:"%d/%m/%Y"}"/>
        </div>
        <div class="form-group">
            <label for="libro">Libro</label>
            <input type="text" class="form-control" name="libro" value="{$loan->getVolume()->getLibro()->getTitolo()}"/>
        </div>
        <div class="form-group">
            <label for="volume">Volume</label>
            <input type="text" class="form-control" name="volume" value="{$loan->getVolume()->getId()}"/>
        </div>
        <div class="form-group">
            <label for="utente">Utente</label>
            <input type="text" class="form-control" name="utente" value="{$loan->getUtente()->getUsername()}"/>
        </div>
    </fieldset>
    <button type="submit" class="btn btn-primary">Chiudi Prestito</button>
</form>