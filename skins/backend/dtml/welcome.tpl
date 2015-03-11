<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">Dashboard</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>

<div class="alert alert-info alert-dismissable">
	<button type="button" class="close" data-dismiss="alert"
		aria-hidden="true">&times;</button>
	<p class="lead">Benvenuto <strong>{$username}!</strong></p>
	<p>Sei nella Dashboard del sito!</p>
</div>
{if $admin}
<div class="row">
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-yellow">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-book fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">{$numberBooks}</div>
						<div>Libri</div>
					</div>
				</div>
			</div>
			<a href="manager-books.php">
				<div class="panel-footer">
					<span class="pull-left">View Details</span> <span
						class="pull-right"><i class="fa fa-arrow-circle-right"></i> </span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-green">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-paperclip fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">{$numberLoans}</div>
						<div>Prestiti</div>
					</div>
				</div>
			</div>
			<a href="manager-loans.php">
				<div class="panel-footer">
					<span class="pull-left">View Details</span> <span
						class="pull-right"><i class="fa fa-arrow-circle-right"></i> </span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-red">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-bell fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">{$numberActiveLoans}</div>
						<div>Prestiti Attivi</div>
					</div>
				</div>
			</div>
			<a href="manager-loans.php?pid=1">
				<div class="panel-footer">
					<span class="pull-left">View Details</span> <span
						class="pull-right"><i class="fa fa-arrow-circle-right"></i> </span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
	<div class="col-lg-3 col-md-6">
		<div class="panel panel-primary">
			<div class="panel-heading">
				<div class="row">
					<div class="col-xs-3">
						<i class="fa fa-user fa-5x"></i>
					</div>
					<div class="col-xs-9 text-right">
						<div class="huge">{$numberUsers}</div>
						<div>Utenti</div>
					</div>
				</div>
			</div>
			<a href="manager-users.php">
				<div class="panel-footer">
					<span class="pull-left">View Details</span> <span
						class="pull-right"><i class="fa fa-arrow-circle-right"></i> </span>
					<div class="clearfix"></div>
				</div>
			</a>
		</div>
	</div>
</div>
{/if}