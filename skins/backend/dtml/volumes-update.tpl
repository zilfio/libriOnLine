{if $warning}
    {include file="alert-warning.tpl"}
{/if}

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Modifica volume</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <fieldset disabled>
        <div class="form-group">
                <label for="libro">Libro</label> <span class="glyphicon glyphicon-ok-circle"></span>
                <select class="form-control" name="libro" disabled="disabled">
                    <option value="{$book->getIsbn()}">{$book->getTitolo()}</option>
                </select>
        </div>
    </fieldset>
    <div class="form-group">
        <label for="condizione">Condizione</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <select class="form-control select2" name="condizione">
            {if $selectedCondition}
            <option selected="selected" value="{$selectedCondition->getId()}">{$selectedCondition->getNome()}</option>
            {/if}
            {foreach from=$conditions item=condition}
                <option value="{$condition->getId()}">{$condition->getNome()}</option>
            {/foreach}
        </select>
    </div>
    <button type="submit" class="btn btn-warning">Modifica Volume</button>
    <button type="reset" class="btn btn-default">Reset</button>
</form>