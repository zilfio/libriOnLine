<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Prestiti attivi</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
{if ($loans|@count gt 0)}
    <div class="alert alert-danger alert-dismissible" role="alert">
        <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button>
        <strong>Attenzione!</strong> I prestiti di color rosso sono scaduti.
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Report Prestiti Attivi
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">                           
                        <table class="table table-striped table-bordered table-hover table-paginated">
                            <thead>
                                <tr>
                                    <th>Libro</th>
                                    <th>ID Volume</th>
                                    <th>Data Prestito</th>
                                    <th>Da restituire entro</th>
                                    <th>Utente</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            {foreach from=$loans item=loan}
                                <tr>
                                    <td {if {$date} > $loan->getDataPresuntaRestituzione()} class="danger"; {/if}> {$loan->getVolume()->getLibro()->getTitolo()} </td>
                                    <td {if {$date} > $loan->getDataPresuntaRestituzione()} class="danger"; {/if}> {$loan->getVolume()->getId()} </td>
                                    <td {if {$date} > $loan->getDataPresuntaRestituzione()} class="danger"; {/if}> {$loan->getDataPrestito()|date_format:"%d/%m/%Y"} </td>
                                    <td {if {$date} > $loan->getDataPresuntaRestituzione()} class="danger"; {/if}> {$loan->getDataPresuntaRestituzione()|date_format:"%d/%m/%Y"} </td>
                                    <td {if {$date} > $loan->getDataPresuntaRestituzione()} class="danger"; {/if}> {$loan->getUtente()->getUsername()} </td>
                                    <td style="text-align:center"> <a href="manager-loans.php?pid=2&amp;id={$loan->getId()}" class="btn btn-primary btn-xs">Chiudi prestito</a> </td>
                                </tr>
                            {/foreach}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{else} {include file="error-no-record.tpl"} {/if}