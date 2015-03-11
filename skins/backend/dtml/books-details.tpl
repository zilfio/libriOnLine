<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dettaglio libro: {$book->getTitolo()}</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<img class="img-responsive img-hover" src="{$book->getCopertina()}" alt="" style="border: 1px solid;" />
<br />
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">Dettaglio libro</div>
			<!-- /.panel-heading -->
			<div class="panel-body">
				<!-- Nav tabs -->
				<ul class="nav nav-tabs">
					<li class="active"><a href="#home" data-toggle="tab">Informazioni</a>
					</li>
					<li><a href="#profile" data-toggle="tab">Prestito</a>
					</li>
					<li><a href="#copielettroniche" data-toggle="tab">Copie elettroniche</a>
					</li>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<div class="tab-pane fade in active" id="home">
						<br />
						<h4>Informazioni libro</h4>
						<br />
						<p>
							<strong>ISBN:</strong> {$book->getIsbn()}
						</p>

						<p>
							<strong>Titolo:</strong> {$book->getTitolo()}
						</p>

						<p>
							<strong>Editore:</strong> {$book->getEditore()->getNome()}
						</p>

						<p>
							<strong>Anno di pubblicazione:</strong>
							{$book->getAnnoPubblicazione()}
						</p>

						<p>
							<strong>Lingua:</strong> {$book->getLingua()->getNome()}
						</p>

						<p>
							<strong>Data d'inserimento:</strong>
							{$book->getDataInserimento()|date_format:"%d/%m/%Y"}
						</p>
					</div>
					<div class="tab-pane fade" id="profile">
						<br />
						<h4>Prestito libro</h4>
						<br />
						<p>
							<strong>Totale volumi:</strong> {$volumiTot}
						</p>

						<p>
							<strong>Volumi disponibili:</strong> {$volumiDisp} {if
							$volumiDisp gt 0} - <a
								href="manager-loans.php?pid=3&amp;isbn={$book->getIsbn()}"
								class="btn btn-primary btn-xs">Procedi con il prestito</a>
							{else if $volumiTot gt 0} <p><strong>Data presunta riconsegna:</strong>
							{$datePrConsegna|date_format:"%d/%m/%Y"} </p> <a
								href="manager-loans.php?pid=6&amp;isbn={$book->getIsbn()}" class="btn btn-primary btn-xs">Visualizza
								i prestiti del libro</a> {/if}
						</p>
					</div>
					<div class="tab-pane fade" id="copielettroniche">
						<br />
						<h4>Copie elettroniche del libro</h4>
						<br />
							{if $electronicCopies}
							{foreach from=$electronicCopies item=electronicCopy}
                            <ul>
                                <li><a href="{$electronicCopy->getPath()}" target="_blank">Copia elettronica - {$electronicCopy->getMimetype()}</a></li>
                            </ul>
                            {/foreach}
                            {else}
                            <p>Nessuna copia elettronica disponibile!</p>
                            {/if}
					</div>
				</div>
			</div>
			<!-- /.panel-body -->
		</div>
		<!-- /.panel -->
	</div>
</div>
