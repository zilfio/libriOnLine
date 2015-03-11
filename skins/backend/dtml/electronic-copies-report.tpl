<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Gestione Copie Elettroniche</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
{if $isbn}
<a href="manager-electronic-copies.php?pid=1&isbn={$isbn}" class="btn btn-primary" role="button">Inserisci copia elettronica</a>
{else}
<a href="manager-electronic-copies.php?pid=1" class="btn btn-primary" role="button">Inserisci copia elettronica</a>
{/if}
<br /><br />
{if ($electronicCopies|@count gt 0)}
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Report Copie Elettroniche
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">                           
                        <table class="table table-striped table-bordered table-hover table-paginated">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Mimetype</th>
                                    <th>Libro</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            {foreach from=$electronicCopies item=electronicCopy}
                                <tr>
                                    <td> {$electronicCopy->getId()} </td>
                                    <td> {$electronicCopy->getMimetype()} </td>
                                    <td> {$electronicCopy->getLibro()->getIsbn()} </td>
                                    <td style="text-align: center"> <a href="{$electronicCopy->getPath()}" title="visualizza copia elettronica" target="_blank"><span class="glyphicon glyphicon-search"></span></a> - <a href="manager-electronic-copies.php?pid=2&amp;id={$electronicCopy->getId()}"><span class="glyphicon glyphicon-remove"></span></a> </td>
                                </tr>
                            {/foreach}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{else} {include file="error-no-record.tpl"} {/if}