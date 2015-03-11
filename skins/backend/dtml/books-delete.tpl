<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Eliminazione libro: {$book->getTitolo()}</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<form role="form" method="POST">
	<input type="hidden" name="page" value="1" />
	<fieldset disabled="disabled">
		<div class="form-group">
			<label for="isbn">ISBN</label> <input type="text"
				class="form-control" name="isbn" value="{$book->getIsbn()}" />
		</div>
		<div class="form-group">
			<label for="titolo">Titolo</label> <input type="text"
				class="form-control" name="titolo" value="{$book->getTitolo()}" />
		</div>
		<div class="form-group">
			<label for="autori">Autori</label> <select multiple
				class="form-control select2" name="autori[]" disabled="disabled">
				{foreach from=$book->getAutori() item=autore}
				<option selected="selected" value="{$autore->getId()}">{$autore->getNome()}
					{$autore->getCognome()}</option> {/foreach}
			</select>
		</div>
		<div class="form-group">
			<label for="annopubblicazione">Anno pubblicazione</label> <input
				type="text" class="form-control" name="annopubblicazione"
				value="{$book->getAnnoPubblicazione()}" />
		</div>
		<div class="form-group">
			<label for="editore">Editore</label> <select
				class="form-control select2" name="editore" disabled="disabled">
				<option value="{$book->getEditore()->getId()}">{$book->getEditore()->getNome()}</option>
			</select>
		</div>
		<div class="form-group">
			<label for="recensione">Recensione</label>
			<textarea class="form-control" name="recensione" disabled="disabled">{$book->getRecensione()}</textarea>
		</div>
		<div class="form-group">
			<label for="lingua">Lingua</label> <select
				class="form-control select2" name="lingua" disabled="disabled">
				<option value="{$book->getLingua()->getId()}">{$book->getLingua()->getNome()}</option>
			</select>
		</div>
		<div class="form-group">
			<label for="tags">Tags</label> <select multiple
				class="form-control select2" name="tags[]" disabled="disabled">
				{foreach from=$book->getTags() item=tag}
				<option selected="selected" value="{$tag->getId()}">{$tag->getNome()}</option>
				{/foreach}
			</select>
		</div>
	</fieldset>
	<button type="submit" class="btn btn-danger">Elimina Libro</button>
</form>
<br /><br />