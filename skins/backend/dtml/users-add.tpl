<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Inserimento utente</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
{if $warning}
    {include file="alert-warning.tpl"}
{/if}
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <div class="form-group">
        <label for="username">Username</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="username" placeholder="Inserisci username" value="{$username}" />
    </div>
    <div class="form-group">
        <label for="username">Password</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="password" class="form-control" name="password" placeholder="Inserisci password" value="{$password}" />
    </div>
    <div class="form-group">
        <label for="nome">Nome</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="nome" placeholder="Inserisci nome" value="{$nome}" />
    </div>
    <div class="form-group">
        <label for="cognome">Cognome</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="cognome" placeholder="Inserisci cognome" value="{$cognome}" />
    </div>
    <div class="form-group">
        <label for="codicefiscale">Codice fiscale</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="codicefiscale" placeholder="Inserisci codicefiscale" value="{$codicefiscale}" />
    </div>
    <div class="form-group">
        <label for="indirizzo">Indirizzo</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="indirizzo" placeholder="Inserisci indirizzo" value="{$indirizzo}" />
    </div>
    <div class="form-group">
        <label for="citta">Citt&agrave;</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="citta" placeholder="Inserisci città" value="{$citta}" />
    </div>
    <div class="form-group">
        <label for="provincia">Provincia</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="provincia" placeholder="Inserisci provincia" value="{$provincia}" />
    </div>
    <div class="form-group">
        <label for="cap">CAP</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="cap" placeholder="Inserisci cap" value="{$cap}" />
    </div>
    <div class="form-group">
        <label for="email">Email</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="email" placeholder="Inserisci email" value="{$email}"/>
    </div>
    <div class="form-group">
        <label for="telefono">Telefono</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="text" class="form-control" name="telefono" placeholder="Inserisci telefono" value="{$telefono}" />
    </div>
    <div class="form-group">
        <label for="gruppi">Gruppi</label>
        <select multiple class="form-control select2" name="gruppi[]" placeholder="Inserisci i gruppi">
            {foreach from=$gruppi item=gruppo}
                <option value="{$gruppo->getId()}">{$gruppo->getNome()}</option>
            {/foreach}
            {foreach from=$gruppiSel item=gruppoSel}
                <option selected="selected" value="{$gruppoSel->getId()}">{$gruppoSel->getNome()}</option>
            {/foreach}
        </select>
    </div>
    <button type="submit" class="btn btn-success">Inserisci Utente</button>
    <button type="reset" class="btn btn-default">Reset</button>
</form>
<br /><br />