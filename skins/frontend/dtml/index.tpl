<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Benvenuti su LibriOnLine</h1>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>
					<i class="fa fa-fw fa-check"></i> Chi siamo
				</h4>
			</div>
			<div class="panel-body">
				<p>LibriOnLine &egrave; un servizio gratuito che mette a disposizione una
					biblioteca online costantemente aggiornata e composta da un vasto
					numero di libri da consultare liberamente e comodamente da casa.</p>
				<a href="about.php" class="btn btn-default">Ulteriori informazioni</a>
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>
					<i class="fa fa-fw fa-gift"></i> Cosa offriamo
				</h4>
			</div>
			<div class="panel-body">
				<p>LibriOnLine mette a disposizione un vasto numero di libri
					cartacei da consultare e richiedere in prestito per una durata
					massima variabile oppure di libri in formato elettronico
					accessibili direttamente online.</p>
				<!-- <a href="#" class="btn btn-default">Ulteriori informazioni</a> -->
			</div>
		</div>
	</div>
	<div class="col-md-4">
		<div class="panel panel-default">
			<div class="panel-heading">
				<h4>
					<i class="fa fa-fw fa-compass"></i> Come funziona
				</h4>
			</div>
			<div class="panel-body">
				<p>E' semplice: accedi al nostro catalogo, trova il libro che ti
					interessa e, se disponibile, richiedene in prestito una copia
					cartacea oppure prelevane una copia gratuita sotto forma di file di
					testo o in formato PDF.</p>
				<!-- <a href="#" class="btn btn-default">Ulteriori informazioni</a> -->
			</div>
		</div>
	</div>
</div>
<!-- /.row -->

<!-- Portfolio Section -->
{if ($moreProvided|@count gt 0)}
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">I libri pi&ugrave; prestati</h2>
	</div>
</div>

<div class="row">
	{foreach from=$moreProvided item=bookProvided}

	<div class="col-lg-3 col-md-4 col-xs-6 thumb">
		<div class="thumbnail">
			<a href="book-detail.php?isbn={$bookProvided->getIsbn()}">
				<div class="caption animated">
					<h4>{$bookProvided->getTitolo()}</h4>
				</div>
				<img src="{$bookProvided->getCopertina()}" alt="...">
			</a>
		</div>
	</div>

	{/foreach}
	</div>
{/if}
<!-- /.row -->

<!-- Portfolio Section -->
{if ($lastBooks|@count gt 0)}
<div class="row">
	<div class="col-lg-12">
		<h2 class="page-header">Gli ultimi aggiunti alla biblioteca</h2>
	</div>
	{foreach from=$lastBooks item=lastBook}
	<div class="col-lg-3 col-md-4 col-xs-6 thumb">
		<div class="thumbnail">
			<a href="book-detail.php?isbn={$lastBook->getIsbn()}">
				<div class="caption animated">
					<h4>{$lastBook->getTitolo()}</h4>
				</div>
				<img src="{$lastBook->getCopertina()}" alt="...">
			</a>
		</div>
	</div>
	{/foreach}
</div>
{/if}
<!-- /.row -->
<hr>

<!-- Call to Action Section -->
<div class="well">
	<div class="row">
		<div class="col-md-8">
			<p>La nostra biblioteca vanta una vasta gamma di libri che &egrave; possibile ricercare in base al codice ISBN, al titolo, al tag (o ai tags), all'autore (o agli autori) e alla lingua. Accedi subito al nostro catalogo online e cerca i libri di tuo interesse.</p>
		</div>
		<div class="col-md-4">
			<a class="btn btn-lg btn-default btn-block" href="book-catalogue.php">Consulta il catalogo</a>
		</div>
	</div>
</div>
