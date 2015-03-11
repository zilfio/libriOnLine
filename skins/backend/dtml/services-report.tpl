<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Gestione Servizi</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<a href="manager-services.php?pid=1" class="btn btn-primary" role="button">Inserisci servizio</a>
<br /><br />
{if ($services|@count gt 0)}
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Report Servizi
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">                           
                        <table class="table table-striped table-bordered table-hover table-paginated">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrizione</th>
                                    <th>Script</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            {foreach from=$services item=service}
                                <tr>
                                    <td> {$service->getNome()} </td>
                                    <td> {$service->getDescrizione()} </td>
                                    <td> {$service->getScript()} </td>
                                    <td style="text-align:center"> <a href="manager-services.php?pid=2&amp;id={$service->getId()}"><span class="glyphicon glyphicon-pencil"></span></a> | <a href="manager-services.php?pid=3&amp;id={$service->getId()}"><span class="glyphicon glyphicon-remove"></span></a> </td>
                                </tr>
                            {/foreach}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{else} {include file="error-no-record.tpl"} {/if}