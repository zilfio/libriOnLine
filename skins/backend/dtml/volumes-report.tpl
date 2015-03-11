<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Gestione Volumi</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
{if $isbn}
    <a href="manager-volumes.php?pid=1&amp;isbn={$isbn}" class="btn btn-primary" role="button">Inserisci volume</a>
{else}
    <a href="manager-volumes.php?pid=1" class="btn btn-primary" role="button">Inserisci volume</a>
{/if}
<br /><br />
{if ($volumes|@count gt 0)}
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Report Volumi
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">                           
                        <table class="table table-striped table-bordered table-hover table-paginated">
                            <thead>
                                <tr>
                                    <th>Copia</th>
                                    <th>Libro</th>
                                    <th>Condizione</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            {foreach from=$volumes item=volume}
                                <tr>
                                    <td> {$volume->getId()} </td>
                                    <td> {$volume->getLibro()->getTitolo()} </td>
                                    <td> {$volume->getCondizione()->getNome()} </td>
                                    <td style="text-align:center"> {if $isbn} <a href="manager-volumes.php?pid=2&amp;id={$volume->getId()}&amp;isbn={$isbn}"><span class="glyphicon glyphicon-pencil"></span></a> {else} <a href="manager-volumes.php?pid=2&amp;id={$volume->getId()}"><span class="glyphicon glyphicon-pencil"></span></a> {/if} | {if $isbn} <a href="manager-volumes.php?pid=3&amp;id={$volume->getId()}&amp;isbn={$isbn}"><span class="glyphicon glyphicon-remove"></span></a> {else} <a href="manager-volumes.php?pid=3&amp;id={$volume->getId()}"><span class="glyphicon glyphicon-remove"></span></a> {/if} </td>
                                </tr>
                            {/foreach}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{else} {include file="error-no-record.tpl"} {/if}