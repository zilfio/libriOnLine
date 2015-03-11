<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Gestione Autori</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<a href="manager-authors.php?pid=1" class="btn btn-primary"
	role="button">Inserisci autore</a>
<br />
<br />
{if ($authors|@count gt 0)}
	<div class="row">
		<div class="col-lg-12">
			<div class="panel panel-default">
				<div class="panel-heading">Report Autori</div>
				<!-- /.panel-heading -->
				<div class="panel-body">
					<div class="table-responsive">
						<table class="table table-striped table-bordered table-hover table-paginated">
							<thead>
								<tr>
									<th>Nome</th>
									<th>Cognome</th>
									<th>Azioni</th>
								</tr>
							</thead>
							{foreach from=$authors item=author}
							<tr>
								<td>{$author->getNome()}</td>
								<td>{$author->getCognome()}</td>
								<td style="text-align:center"><a href="manager-authors.php?pid=2&amp;id={$author->getId()}"><span
										class="glyphicon glyphicon-pencil"></span> </a> | <a
									href="manager-authors.php?pid=3&amp;id={$author->getId()}"><span
										class="glyphicon glyphicon-remove"></span> </a>
								</td>
							</tr>
							{/foreach}
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
{else} {include file="error-no-record.tpl"} {/if}
