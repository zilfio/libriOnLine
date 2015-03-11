<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Gestione Libri</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<a href="manager-books.php?pid=1" class="btn btn-primary" role="button">Inserisci libro</a>
<br /><br />
{if ($books|@count gt 0)}
    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">
                    Report Libri
                </div>
                <!-- /.panel-heading -->
                <div class="panel-body">
                    <div class="table-responsive">                           
                        <table class="table table-striped table-bordered table-hover table-paginated">
                            <thead>
                                <tr>
                                    <th>ISBN</th>
                                    <th>Titolo</th>
                                    <th>Editore</th>
                                    <th>Anno</th>
                                    <th>Azioni</th>
                                </tr>
                            </thead>
                            {foreach from=$books item=book}
                                <tr>
                                    <td> {$book->getIsbn()} </td>
                                    <td> {$book->getTitolo()} </td>
                                    <td> {$book->getEditore()->getNome()} </td>
                                    <td> {$book->getAnnoPubblicazione()} </td> 
                                    <td style="text-align:center"> <a title="dettaglio libro" href="manager-books.php?pid=4&amp;isbn={$book->getIsbn()}"><span class="glyphicon glyphicon-search"></span></a> | <a title="modifica libro" href="manager-books.php?pid=2&amp;isbn={$book->getIsbn()}"><span class="glyphicon glyphicon-pencil"></span></a> | <a title="elimina libro" href="manager-books.php?pid=3&amp;isbn={$book->getIsbn()}"><span class="glyphicon glyphicon-remove"></span></a> | <a title="gestione volumi" href="manager-volumes.php?isbn={$book->getIsbn()}"><span class="glyphicon glyphicon-book"></span></a> | <a title="gestione copie elettroniche" href="manager-electronic-copies.php?isbn={$book->getIsbn()}"><span class="glyphicon glyphicon-cloud-upload"></span></a> </td>
                                </tr>
                            {/foreach}
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
{else} {include file="error-no-record.tpl"} {/if}