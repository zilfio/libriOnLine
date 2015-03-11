<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">
			Dettaglio libro <small>{$book->getTitolo()}</small>
		</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Home</a>
			</li>
			<li><a href="book-catalogue.php">Catalogo libri</a>
			</li>
			<li class="active">Dettaglio libro - isbn: {$book->getIsbn()}</li>
		</ol>
	</div>
</div>
<!-- /.row -->

<!-- Portfolio Item Row -->
<div class="row">

	<div class="col-md-3">
		<br /> <img src="{$book->getCopertina()}" alt="..."
			style="border: 1px solid;">
	</div>

	<div class="col-md-9">
		<h2>{$book->getTitolo()}</h2>
		<p><strong>ISBN</strong>: {$book->getIsbn()}</p>
		<p><strong>Editore</strong>: {$book->getEditore()->getNome()}</p>
		{if $book->getAnnoPubblicazione()}
		<p><strong>Anno di pubblicazione: </strong>{$book->getAnnoPubblicazione()}</p>
		{/if} {if $book->getRecensione()}
		<p><strong>Recensione: </strong><br />{$book->getRecensione()}</p>
		{/if}
		<p><strong>Lingua: </strong>{$book->getLingua()->getNome()}</p>
		{if $book->getAutori()|@count gt 0}
		<p><strong>Autori</strong></p>
		<ul>
			{foreach from=$book->getAutori() item=autore}
			<li><a href="search.php?pid=2&amp;author={$autore->getId()}">{$autore->getNome()}
					{$autore->getCognome()}</a></li> {/foreach}
		</ul>
		{/if} {if $book->getTags()|@count gt 0}
		<p><strong>Tag</strong></p>
		<ul>
			{foreach from=$book->getTags() item=tag}
			<li><a href="search.php?pid=3&amp;tag={$tag->getId()}">{$tag->getNome()}</a>
			</li> {/foreach}
		</ul>
		{/if}
		{if $electronicCopies}
		<p><strong>Copie elettroniche del libro</strong></p>
		{foreach from=$electronicCopies
		item=electronicCopy}
		<ul>
			<li><a href="{$electronicCopy->getPath()}" target="_blank">Copia
					elettronica - {$electronicCopy->getMimetype()}</a></li>
		</ul>
		{/foreach}
		{/if}
		{if $loggato}
		<h3 class="page-header">Nella nostra biblioteca</h3>
		<p><strong>Totale volumi</strong>: {$volumiTot}</p>
		<p><strong>Volumi disponibili</strong>: {$volumiDisp}</p>
		{if $volumiDisp gt 0 && $admin} 
			<p> <strong>Prestito libro: </strong><a href="manager-loans.php?pid=3&amp;isbn={$book->getIsbn()}" class="btn btn-primary btn-xs">Procedi con il prestito</a> </p>
		{/if}
		{if $volumiTot neq 0 && $volumiDisp eq 0}
		<p> <strong>Data presunta riconsegna:</strong> {$datePrConsegna|date_format:"%d/%m/%Y"} </p>
		{/if}
		{if $volumiTot neq 0 && $admin}		
		<p> <strong>Storico prestiti libro: </strong><a href="manager-loans.php?pid=6&amp;isbn={$book->getIsbn()}" class="btn btn-primary btn-xs">Visualizza i prestiti</a>
		{/if}
		{/if}
	</div>

</div>
<!-- /.row -->

<!-- Related Projects Row -->
{if $relatedBooks|@count gt 0}
<div class="row">

	<div class="col-lg-12">
		<h3 class="page-header">Altri libri</h3>
	</div>

	{foreach from=$relatedBooks item=relatedBook}
	<div class="col-lg-3 col-md-4 col-xs-6 thumb">
		<div class="thumbnail">
			<a href="book-detail.php?isbn={$relatedBook->getIsbn()}">
				<div class="caption animated">
					<h4>{$relatedBook->getTitolo()}</h4>
				</div> <img src="{$relatedBook->getCopertina()}" alt="...">
			</a>
		</div>
	</div>
	{/foreach}
</div>
{/if}
