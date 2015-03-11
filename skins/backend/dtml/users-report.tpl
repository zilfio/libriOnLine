<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Gestione Utenti</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<a href="manager-users.php?pid=1" class="btn btn-primary" role="button">Inserisci utente</a>
<br /><br />
{if ($users|@count gt 0)}
	<div class="row">
	    <div class="col-lg-12">
	        <div class="panel panel-default">
	            <div class="panel-heading">
	                Report Utenti
	            </div>
	            <!-- /.panel-heading -->
	            <div class="panel-body">
	                <div class="table-responsive">                           
	                    <table class="table table-striped table-bordered table-hover table-paginated">
	                        <thead>
	                            <tr>
	                                <th>Username</th>
	                                <th>Nome</th>
	                                <th>Cognome</th>
	                                <th>Email</th>
	                                <th>Data registrazione</th>
	                                <th>Azioni</th>
	                            </tr>
	                        </thead>
	                        {foreach from=$users item=user}
	                            <tr>
	                                <td> {$user->getUsername()} </td>
	                                <td> {$user->getNome()} </td>
	                                <td> {$user->getCognome()} </td>
	                                <td> {$user->getEmail()} </td>
	                                <td> {$user->getDataRegistrazione()|date_format:"%d/%m/%Y"} </td>
	                                <td style="text-align:center"> <a href="manager-users.php?pid=2&amp;id={$user->getId()}" title="Modifica utente"><span class="glyphicon glyphicon-pencil"></span></a> | <a href="manager-users.php?pid=3&amp;id={$user->getId()}" title="Elimina utente"><span class="glyphicon glyphicon-remove"></span></a> | <a href="manager-users.php?pid=4&amp;id={$user->getId()}" title="Modifica la password"><span class="glyphicon glyphicon-lock"></span></a> </td>
	                            </tr> 
	                        {/foreach}
	                    </table>
	                </div>
	            </div>
	        </div>
	    </div>
	</div>
{else} {include file="error-no-record.tpl"} {/if}