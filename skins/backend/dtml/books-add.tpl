<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Inserimento libro</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
{if $warning} {include file="alert-warning.tpl"} {/if} {if $error}
{include file="alert-error.tpl"} {/if}
<form role="form" method="POST" enctype="multipart/form-data">
	<input type="hidden" name="page" value="1" />
	<div class="form-group">
		<label for="isbn">ISBN</label> <span
			class="glyphicon glyphicon-ok-circle"></span> <input type="text"
			class="form-control" name="isbn" placeholder="Inserisci isbn"
			value="{$isbn}" />
	</div>
	<div class="form-group">
		<label for="nome">Titolo</label> <span
			class="glyphicon glyphicon-ok-circle"></span> <input type="text"
			class="form-control" name="titolo" placeholder="Inserisci titolo"
			value="{$titolo}" />
	</div>
	<div class="form-group">
		<label for="autori">Autori</label> <select multiple
			class="form-control select2" name="autori[]"
			placeholder="Inserisci autori"> {foreach from=$autori item=autore}
			<option value="{$autore->getId()}">{$autore->getNome()}
				{$autore->getCognome()}</option> {/foreach} {foreach from=$autoriSel
			item=autoreSel}
			<option selected="selected" value="{$autoreSel->getId()}">{$autoreSel->getNome()}
				{$autoreSel->getCognome()}</option> {/foreach}
		</select>
	</div>
	<div class="form-group">
		<label for="annopubblicazione">Anno pubblicazione</label> <input
			type="text" class="form-control" name="annopubblicazione"
			placeholder="Inserisci anno pubblicazione"
			value="{$annopubblicazione}" />
	</div>
	<div class="form-group">
		<label for="editore">Editore</label> <select
			class="form-control select2" name="editore"> {if $selectedEditor}
			<option selected="selected" value="{$selectedEditor->getId()}">{$selectedEditor->getNome()}</option>
			{/if} {foreach from=$editors item=editor}
			<option value="{$editor->getId()}">{$editor->getNome()}</option>
			{/foreach}
		</select>
	</div>
	<div class="form-group">
		<label for="recensione">Recensione</label>
		<textarea class="form-control" name="recensione"
			placeholder="Inserisci recensione">{$recensione}</textarea>
	</div>
	<div class="form-group">
		<label for="lingua">Lingua</label> <select
			class="form-control select2" name="lingua"> {if $selectedLanguage}
			<option selected="selected" value="{$selectedLanguage->getId()}">{$selectedLanguage->getNome()}</option>
			{/if} {foreach from=$languages item=language}
			<option value="{$language->getId()}">{$language->getNome()}</option>
			{/foreach}
		</select>
	</div>
	<div class="form-group">
		<label for="tags">Tags</label> <select multiple
			class="form-control select2" name="tags[]"
			placeholder="Inserisci tag"> {foreach from=$tags item=tag}
			<option value="{$tag->getId()}">{$tag->getNome()}</option> {/foreach}
			{foreach from=$tagsSel item=tagSel}
			<option selected="selected" value="{$tagSel->getId()}">{$tagSel->getNome()}</option>
			{/foreach}
		</select>
	</div>
	<div class="form-group">
		<label for="electronic_copy">Immagine di copertina</label>
		<input id="electronic_copy" name="electronic_copy" type="file" class="file-loading" data-show-upload="false" />
	</div>
	<button type="submit" class="btn btn-success">Inserisci Libro</button>
	<button type="reset" class="btn btn-default">Reset</button>
</form>
<br /><br />