<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Inserimento volume</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
{if $warning}
    {include file="alert-warning.tpl"}
{/if}
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <div class="form-group">
        <label for="numeroVolumi">Numero volumi</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="number" class="form-control" name="numeroVolumi" placeholder="Inserisci numero di volumi" value="1" autofocus autocomplete="off" />
    </div>
    <div class="form-group">
        <label for="condizione">Condizione</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <select class="form-control select2" name="condizione" id="prova">
            {if $selectedCondition}
                <option selected="selected" value="{$selectedCondition->getId()}">{$selectedCondition->getNome()}</option>
            {/if}
            {foreach from=$condizioni item=condizione}
                <option value="{$condizione->getId()}">{$condizione->getNome()}</option>
            {/foreach}
        </select>
    </div>
    {if $book}
        <div class="form-group">
            <label for="libro">Libro</label> <span class="glyphicon glyphicon-ok-circle"></span>
            <select class="form-control select2" name="libro">
                {if $selectedBook}
                    <option selected="selected" value="{$selectedBook->getIsbn()}">{$selectedBook->getTitolo()}</option>
                {/if}
                {foreach from=$books item=book}
                    <option value="{$book->getIsbn()}">{$book->getTitolo()}</option>
                {/foreach}
            </select>
        </div>
    {/if}
    <button type="submit" class="btn btn-success">Inserisci Volume</button>
    <button type="reset" class="btn btn-default">Reset</button>
</form>