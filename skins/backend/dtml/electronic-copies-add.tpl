<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Inserimento copia elettronica</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
{if $warning} {include file="alert-warning.tpl"} {/if} {if $error}
{include file="alert-error.tpl"} {/if}
<form method="post" enctype="multipart/form-data">
	<input type="hidden" name="page" value="1" />
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
    <label for="electronic_copy">Copia elettronica</label> <span class="glyphicon glyphicon-ok-circle"></span>
	<input id="electronic_copy" name="electronic_copy" type="file" class="file-loading" />
</form>