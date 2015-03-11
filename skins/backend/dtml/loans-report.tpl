<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Gestione Prestiti</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
{if ($loans|@count gt 0)}
	<!--
	<div class="alert alert-custom alert-success-custom alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Attenzione!</strong> I prestiti di color verde sono stati chiusi correttamente.
    </div>
    <div class="alert alert-custom alert-warning-custom alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Attenzione!</strong> I prestiti di color arancio sono stati restituiti ma in ritardo rispetto alla presunta data di restituzione.
    </div>
    <div class="alert alert-custom alert-danger-custom alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Attenzione!</strong> I prestiti di color rosso sono scaduti e non sono ancora stati restituiti.
    </div>
    <div class="alert alert-custom alert-info-custom alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Attenzione!</strong> I prestiti di color blu sono regolarmente in corso di prestito.
    </div>
    -->
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Legenda
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">                           
                        <table class="table table-striped table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th>Colore</th>
                                    <th>Testo</th>
                                </tr>
                            </thead>
                                <tr>
                                    <td style="background-color: #006600";> </td>
                                    <td> I prestiti di color verde sono stati chiusi correttamente. </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #f28226";> </td>
                                    <td> I prestiti di color arancio sono stati restituiti ma in ritardo rispetto alla presunta data di restituzione. </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #dd4b39"> </td>
                                    <td> I prestiti di color rosso sono scaduti e non sono ancora stati restituiti.. </td>
                                </tr>
                                <tr>
                                    <td style="background-color: #1D599C"> </td>
                                    <td> I prestiti di color blu sono regolarmente in corso di prestito. </td>
                                </tr>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Report Prestiti
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">                           
                        <table class="table table-striped table-bordered table-hover table-paginated">
                            <thead>
                                <tr>
                                    <th>Codice</th>
                                    <th>Libro</th>
                                    <th>ID Volume</th>
                                    <th>Data Prestito</th>
                                    <th>Da restituire entro</th>
                                    <th>Data Restituzione</th>
                                    <th>Stato</th>
                                    <th>Utente</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            {foreach from=$loans item=loan}
                                <tr>
                                    <td> {$loan->getId()} </td>
                                    <td> {$loan->getVolume()->getLibro()->getTitolo()} </td>
                                    <td> {$loan->getVolume()->getId()} </td>
                                    <td> {$loan->getDataPrestito()|date_format:"%d/%m/%Y"} </td>
                                    <td> {$loan->getDataPresuntaRestituzione()|date_format:"%d/%m/%Y"} </td>
                                    <td> {if $loan->getDataRestituzione() eq NULL} / {else} {$loan->getDataRestituzione()|date_format:"%d/%m/%Y"} {/if} </td>
                                    <td {if $loan->getDataRestituzione() neq null and $loan->getDataRestituzione() > $loan->getDataPresuntaRestituzione()} style="background-color: #f28226";
										{elseif $loan->getDataRestituzione() neq null and $loan->getDataRestituzione() <= $loan->getDataPresuntaRestituzione()} style="background-color: #006600";
										{elseif $loan->getDataRestituzione() eq null and $date > $loan->getDataPresuntaRestituzione()} style="background-color: #dd4b39";
										{elseif $loan->getDataRestituzione() eq null and $date <= $loan->getDataPresuntaRestituzione()} style="background-color: #1D599C";
										{/if}>
									</td>
                                    <td> {$loan->getUtente()->getUsername()} </td>
                                    <td style="text-align:center"> <a href="manager-loans.php?pid=4&amp;id={$loan->getId()}"><span class="glyphicon glyphicon-pencil"></span></a> | <a href="manager-loans.php?pid=5&amp;id={$loan->getId()}"><span class="glyphicon glyphicon-remove"></span></a> </td>
                                </tr>
                            {/foreach}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{else} {include file="error-no-record.tpl"} {/if}