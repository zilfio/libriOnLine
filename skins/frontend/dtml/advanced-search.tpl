<!-- Page Heading/Breadcrumbs -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Ricerca avanzata</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Home</a></li>
			<li><a href="book-catalogue.php">Catalogo libri</a></li>
			<li class="active">Ricerca avanzata</li>
		</ol>
	</div>
</div>
<!-- /.row -->

<!-- Content Row -->
<div class="col-lg-12">
	<form role="form" method="POST">
		<input type="hidden" name="page" value="1" />
		<div class="form-group">
			<label for="isbn">ISBN</label> 
			<input type="text"
				class="form-control" name="isbn" placeholder="Inserisci isbn del libro da cercare"
				value="{$isbn}" />
		</div>
		<div class="form-group">
			<label for="nome">Titolo</label> 
			<input type="text"
				class="form-control" name="titolo" placeholder="Inserisci il titolo del libro da cercare"
				value="{$titolo}" />
		</div>
		<div class="form-group">
		<div class="radio">
			<label class="radio-inline"><input type="radio" name="typeSearchTitolo" value="1" checked="checked" />Parte del titolo</label> 
			<label class="radio-inline"><input type="radio" name="typeSearchTitolo" value="2" />Titolo esatto</label> 
		</div>
		</div>
		<div class="form-group">
		<label for="autori">Autori</label> <select multiple
			class="form-control select2" name="autori[]"
			placeholder="Inserisci gli autori del libro da cercare"> {foreach from=$autori item=autore}
			<option value="{$autore->getId()}">{$autore->getNome()}
				{$autore->getCognome()}</option> {/foreach} {foreach from=$autoriSel
			item=autoreSel}
			<option selected="selected" value="{$autoreSel->getId()}">{$autoreSel->getNome()}
				{$autoreSel->getCognome()}</option> {/foreach}
		</select>
		</div>
		<div class="form-group">
		<label for="tags">Tags</label> 
		<select multiple
			class="form-control select2" name="tags[]"
			placeholder="Inserisci i tag del libro da cercare"> {foreach from=$tags item=tag}
			<option value="{$tag->getId()}">{$tag->getNome()}</option> {/foreach}
			{foreach from=$tagsSel item=tagSel}
			<option selected="selected" value="{$tagSel->getId()}">{$tagSel->getNome()}</option>
			{/foreach}
		</select>
		</div>
		<div class="form-group">
		<label for="lingua">Lingua</label> 
			<select class="form-control select2" name="lingua">  
			<option value="0">Tutte le lingue</option>
			{foreach from=$languages item=language}
				<option value="{$language->getId()}">{$language->getNome()}</option>
			{/foreach}
		</select>
	</div>
		<button type="submit" class="btn btn-primary">Cerca Libro</button>
	</form>
	<br /><br />
</div>
