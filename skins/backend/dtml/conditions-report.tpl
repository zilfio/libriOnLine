<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Gestione Condizioni</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<a href="manager-conditions.php?pid=1" class="btn btn-primary" role="button">Inserisci condizione</a>
<br /><br />
{if ($conditions|@count gt 0)}
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Report Condizioni
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">                           
                        <table class="table table-striped table-bordered table-hover table-paginated">
                            <thead>
                                <tr>
                                    <th>Nome</th>
                                    <th>Descrizione</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            {foreach from=$conditions item=condition}
                                <tr>
                                    <td> {$condition->getNome()} </td>
                                    <td> {$condition->getDescrizione()} </td>
                                    <td style="text-align:center"> <a href="manager-conditions.php?pid=2&amp;id={$condition->getId()}"><span class="glyphicon glyphicon-pencil"></span></a> | <a href="manager-conditions.php?pid=3&amp;id={$condition->getId()}"><span class="glyphicon glyphicon-remove"></span></a> </td>
                                </tr>
                            {/foreach}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{else} {include file="error-no-record.tpl"} {/if}