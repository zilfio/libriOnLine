<!-- Page Heading/Breadcrumbs -->
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">{$pageTitle}</h1>
		<ol class="breadcrumb">
			<li><a href="index.php">Home</a>
			</li>
			{if $catalogue}
			<li class="active">Catalogo libri</li>
			{else}
			<li><a href="book-catalogue.php">Catalogo libri</a>
			</li>
			<li class="active">Risultati ricerca</li>
			{/if}
		</ol>
	</div>
</div>
<!-- /.row -->

<!-- Projects Row -->

<div class="col-lg-12" style="margin-bottom: 15px;">
	<form class="form-horizontal" role="form" action="search.php"
		method="get">
		<div class="form-group input-group">
			<input type="text" class="form-control"
				placeholder="Inserisci il titolo del libro da cercare" name="title">
			<span class="input-group-btn">
				<button class="btn btn-default" type="submit">
					<i class="fa fa-search"></i>
				</button>
			</span>
		</div>
	</form>
	<a href="search.php?pid=1">Ricerca avanzata</a>
</div>


{if ($books|@count gt 0)}
<div class="row">
	<div id="books-container" class="container">
		{foreach from=$books item=book}
		<div class="col-lg-3 col-md-4 col-xs-6 thumb">
			<div class="content">
				<div class="thumbnail">
					<a href="book-detail.php?isbn={$book->getIsbn()}">
						<div class="caption animated">
							<h4>{$book->getTitolo()}</h4>
						</div> <img src="{$book->getCopertina()}" alt="...">
					</a>
				</div>
			</div>
		</div>
		{/foreach}
		<div style="clear: both;"></div>
		<div class="page_navigation"
			style="text-align: center; margin-top: 10px; margin-bottom: 10px;"></div>
	</div>
</div>
<!-- /.row -->

{else}
<div class="col-lg-12">
	<div class="alert alert-warning alert-dismissable">
		<button type="button" class="close" data-dismiss="alert"
			aria-hidden="true">&times;</button>
		<strong>Attenzione!</strong> Nessun libro trovato!
	</div>
</div>
{/if}
<!-- /.row -->
