{if $warning}
    {include file="alert-warning.tpl"}
{/if}

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">Modifica password</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<form role="form" method="POST">
    <input type="hidden" name="page" value="1" />
    <div class="form-group">
        <label for="password">Password</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="password" class="form-control" name="password" placeholder="Inserisci la password" />
    </div>
    <div class="form-group">
        <label for="email">Conferma password</label> <span class="glyphicon glyphicon-ok-circle"></span>
        <input type="password" class="form-control" name="password2" placeholder="Reinserisci la password" />
    </div>
    <button type="submit" class="btn btn-primary">Cambia Password</button>
    <button type="reset" class="btn btn-default">Reset</button>
</form>